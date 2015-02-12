<?php

namespace Handy\UbiquitousMusicBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Handy\UbiquitousMusicBundle\Entity\MusicItem;
use Handy\UbiquitousMusicBundle\Form\MusicItemType;

/**
 * MusicItem controller.
 *
 */
class MusicItemController extends Controller
{

    /**
     * Lists all MusicItem entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('UbiquitousMusicBundle:MusicItem')->findAll();

        return $this->render('UbiquitousMusicBundle:MusicItem:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new MusicItem entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new MusicItem();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('musicitem_show', array('id' => $entity->getId())));
        }

        return $this->render('UbiquitousMusicBundle:MusicItem:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a MusicItem entity.
     *
     * @param MusicItem $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(MusicItem $entity)
    {
        $form = $this->createForm(new MusicItemType(), $entity, array(
            'action' => $this->generateUrl('musicitem_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new MusicItem entity.
     *
     */
    public function newAction()
    {
        $entity = new MusicItem();
        $form   = $this->createCreateForm($entity);

        return $this->render('UbiquitousMusicBundle:MusicItem:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a MusicItem entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UbiquitousMusicBundle:MusicItem')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MusicItem entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('UbiquitousMusicBundle:MusicItem:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing MusicItem entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UbiquitousMusicBundle:MusicItem')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MusicItem entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('UbiquitousMusicBundle:MusicItem:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a MusicItem entity.
    *
    * @param MusicItem $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(MusicItem $entity)
    {
        $form = $this->createForm(new MusicItemType(), $entity, array(
            'action' => $this->generateUrl('musicitem_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing MusicItem entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UbiquitousMusicBundle:MusicItem')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MusicItem entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('musicitem_edit', array('id' => $id)));
        }

        return $this->render('UbiquitousMusicBundle:MusicItem:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a MusicItem entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('UbiquitousMusicBundle:MusicItem')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find MusicItem entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('musicitem'));
    }

    /**
     * Creates a form to delete a MusicItem entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('musicitem_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
