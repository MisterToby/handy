<?php

namespace Handy\FlightMonitorBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use Handy\FlightMonitorBundle\Entity\Trip;
use Handy\FlightMonitorBundle\Entity\Record;
use Handy\FlightMonitorBundle\Form\TripType;

use \DateTime;

/**
 * Trip controller.
 *
 */
class TripController extends Controller {
    public function reportAction($id) {
        $em = $this -> getDoctrine() -> getManager();

        $entity = $em -> find('FlightMonitorBundle:Trip', $id);

        $qb = $em -> createQueryBuilder();
        $qb -> select('rec');
        $qb -> from('FlightMonitorBundle:Record', 'rec');
        $qb -> where("rec.recTri = $id");
        $qb -> orderBy('rec.recDate');

        $query = $qb -> getQuery();
        $entities = $query -> getResult();

        return $this -> render('FlightMonitorBundle:Trip:report.html.twig', array('entities' => $entities));
    }

    public function processInternationalTripAvianca($response) {
        $startPattern = 'var generatedJSon = new String(\'';
        $index = strrpos($response, $startPattern) + strlen($startPattern);
        $endPattern = 'var jsonExpression';
        $response = substr($response, $index);
        $index = strrpos($response, $endPattern) - 9;
        $response = substr($response, 0, $index);

        $array = json_decode($response, TRUE);

        $lowestOutboundPrice = $array['list_tab']['list_recommendation'][0]['list_price'][0]['price'];
        $lowestInboundPrice = $array['list_tab']['list_recommendation'][0]['list_price'][1]['price'];

        $record = new Record();
        $record -> setRecLowestOutboundPrice($lowestOutboundPrice);
        $record -> setRecLowestInboundPrice($lowestInboundPrice);
        $record -> setRecDate(new DateTime('now'));

        return $record;
    }

    public function monitorAction() {
        $em = $this -> getDoctrine() -> getManager();

        $entities = $em -> getRepository('FlightMonitorBundle:Trip') -> findAll();

        foreach ($entities as $key => $entity) {
            $airline = $entity -> getTriAir();

            $ch = curl_init($airline -> getAirUrl());

            curl_setopt($ch, CURLOPT_POST, TRUE);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $entity -> getTriFields());
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

            $response = curl_exec($ch);

            curl_close($ch);

            $record = call_user_func(array($this, $entity -> getTriProcessingMethod()), $response);

            $record -> setRecTri($entity);
            $em -> persist($record);
            $em -> flush();
        }

        return new Response('Ok');
    }

    /**
     * Lists all Trip entities.
     *
     */
    public function indexAction() {
        $em = $this -> getDoctrine() -> getManager();

        $entities = $em -> getRepository('FlightMonitorBundle:Trip') -> findAll();

        return $this -> render('FlightMonitorBundle:Trip:index.html.twig', array('entities' => $entities, ));
    }

    /**
     * Creates a new Trip entity.
     *
     */
    public function createAction(Request $request) {
        $entity = new Trip();
        $form = $this -> createCreateForm($entity);
        $form -> handleRequest($request);

        if ($form -> isValid()) {
            $em = $this -> getDoctrine() -> getManager();
            $em -> persist($entity);
            $em -> flush();

            return $this -> redirect($this -> generateUrl('trip_show', array('id' => $entity -> getId())));
        }

        return $this -> render('FlightMonitorBundle:Trip:new.html.twig', array('entity' => $entity, 'form' => $form -> createView(), ));
    }

    /**
     * Creates a form to create a Trip entity.
     *
     * @param Trip $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Trip $entity) {
        $form = $this -> createForm(new TripType(), $entity, array('action' => $this -> generateUrl('trip_create'), 'method' => 'POST', ));

        $form -> add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Trip entity.
     *
     */
    public function newAction() {
        $entity = new Trip();
        $form = $this -> createCreateForm($entity);

        return $this -> render('FlightMonitorBundle:Trip:new.html.twig', array('entity' => $entity, 'form' => $form -> createView(), ));
    }

    /**
     * Finds and displays a Trip entity.
     *
     */
    public function showAction($id) {
        $em = $this -> getDoctrine() -> getManager();

        $entity = $em -> getRepository('FlightMonitorBundle:Trip') -> find($id);

        if (!$entity) {
            throw $this -> createNotFoundException('Unable to find Trip entity.');
        }

        $deleteForm = $this -> createDeleteForm($id);

        return $this -> render('FlightMonitorBundle:Trip:show.html.twig', array('entity' => $entity, 'delete_form' => $deleteForm -> createView(), ));
    }

    /**
     * Displays a form to edit an existing Trip entity.
     *
     */
    public function editAction($id) {
        $em = $this -> getDoctrine() -> getManager();

        $entity = $em -> getRepository('FlightMonitorBundle:Trip') -> find($id);

        if (!$entity) {
            throw $this -> createNotFoundException('Unable to find Trip entity.');
        }

        $editForm = $this -> createEditForm($entity);
        $deleteForm = $this -> createDeleteForm($id);

        return $this -> render('FlightMonitorBundle:Trip:edit.html.twig', array('entity' => $entity, 'edit_form' => $editForm -> createView(), 'delete_form' => $deleteForm -> createView(), ));
    }

    /**
     * Creates a form to edit a Trip entity.
     *
     * @param Trip $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Trip $entity) {
        $form = $this -> createForm(new TripType(), $entity, array('action' => $this -> generateUrl('trip_update', array('id' => $entity -> getId())), 'method' => 'PUT', ));

        $form -> add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Trip entity.
     *
     */
    public function updateAction(Request $request, $id) {
        $em = $this -> getDoctrine() -> getManager();

        $entity = $em -> getRepository('FlightMonitorBundle:Trip') -> find($id);

        if (!$entity) {
            throw $this -> createNotFoundException('Unable to find Trip entity.');
        }

        $deleteForm = $this -> createDeleteForm($id);
        $editForm = $this -> createEditForm($entity);
        $editForm -> handleRequest($request);

        if ($editForm -> isValid()) {
            $em -> flush();

            return $this -> redirect($this -> generateUrl('trip_edit', array('id' => $id)));
        }

        return $this -> render('FlightMonitorBundle:Trip:edit.html.twig', array('entity' => $entity, 'edit_form' => $editForm -> createView(), 'delete_form' => $deleteForm -> createView(), ));
    }

    /**
     * Deletes a Trip entity.
     *
     */
    public function deleteAction(Request $request, $id) {
        $form = $this -> createDeleteForm($id);
        $form -> handleRequest($request);

        if ($form -> isValid()) {
            $em = $this -> getDoctrine() -> getManager();
            $entity = $em -> getRepository('FlightMonitorBundle:Trip') -> find($id);

            if (!$entity) {
                throw $this -> createNotFoundException('Unable to find Trip entity.');
            }

            $em -> remove($entity);
            $em -> flush();
        }

        return $this -> redirect($this -> generateUrl('trip'));
    }

    /**
     * Creates a form to delete a Trip entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this -> createFormBuilder() -> setAction($this -> generateUrl('trip_delete', array('id' => $id))) -> setMethod('DELETE') -> add('submit', 'submit', array('label' => 'Delete')) -> getForm();
    }

}
