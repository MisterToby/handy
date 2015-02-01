<?php

namespace Handy\FlightMonitorBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Handy\FlightMonitorBundle\Entity\Airline;
use Handy\FlightMonitorBundle\Form\AirlineType;

/**
 * Airline controller.
 *
 */
class AirlineController extends Controller
{

    /**
     * Lists all Airline entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('FlightMonitorBundle:Airline')->findAll();

        return $this->render('FlightMonitorBundle:Airline:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Airline entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Airline();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('airline_show', array('id' => $entity->getId())));
        }

        return $this->render('FlightMonitorBundle:Airline:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Airline entity.
     *
     * @param Airline $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Airline $entity)
    {
        $form = $this->createForm(new AirlineType(), $entity, array(
            'action' => $this->generateUrl('airline_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Airline entity.
     *
     */
    public function newAction()
    {
        $entity = new Airline();
        $form   = $this->createCreateForm($entity);

        return $this->render('FlightMonitorBundle:Airline:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Airline entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FlightMonitorBundle:Airline')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Airline entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('FlightMonitorBundle:Airline:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Airline entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FlightMonitorBundle:Airline')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Airline entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('FlightMonitorBundle:Airline:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Airline entity.
    *
    * @param Airline $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Airline $entity)
    {
        $form = $this->createForm(new AirlineType(), $entity, array(
            'action' => $this->generateUrl('airline_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Airline entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FlightMonitorBundle:Airline')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Airline entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('airline_edit', array('id' => $id)));
        }

        return $this->render('FlightMonitorBundle:Airline:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Airline entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('FlightMonitorBundle:Airline')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Airline entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('airline'));
    }

    /**
     * Creates a form to delete a Airline entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('airline_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
