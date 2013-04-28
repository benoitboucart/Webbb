<?php

namespace Webbb\Bundle\FormBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Webbb\Bundle\FormBundle\Entity\Form;
use Webbb\Bundle\FormBundle\Form\Type\FormType;

/**
 * Form controller.
 *
 * @Route("/form")
 */
class FormController extends Controller
{
    /**
     * Lists all Form entities.
     *
     * @Route("/", name="form")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('WebbbFormBundle:Form')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new Form entity.
     *
     * @Route("/", name="form_create")
     * @Method("POST")
     * @Template("WebbbFormBundle:Form:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Form();
        $form = $this->createForm($this->get('webbb_form.form.type.form'), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('form_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Form entity.
     *
     * @Route("/new", name="form_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Form();
        $form   = $this->createForm($this->get('webbb_form.form.type.form'), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Form entity.
     *
     * @Route("/{id}", name="form_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('WebbbFormBundle:Form')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Form entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Renders a form based on the form entity.
     *
     * @Route("/{id}/render", name="form_render")
     * @Method({"GET","POST"})
     * @Template()
     */
    public function renderAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('WebbbFormBundle:Form')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Form entity.');
        }

        // Generate the form!
        $generated_form = $this->createForm(
            $this->get('webbb_form.form.type.generator.formgenerator'), $entity, array(
                // 'form_entity_data' => $entity,
            )
        );

        if($request->getMethod() == "POST"){
            $generated_form->bind($request);
            if ($generated_form->isValid())
                echo "FORM IS VALID!";
        }

        return array(
            'entity'            => $entity,
            'generated_form'    => $generated_form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Form entity.
     *
     * @Route("/{id}/edit", name="form_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('WebbbFormBundle:Form')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Form entity.');
        }

        $editForm = $this->createForm($this->get('webbb_form.form.type.form'), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Form entity.
     *
     * @Route("/{id}", name="form_update")
     * @Method("PUT")
     * @Template("WebbbFormBundle:Form:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('WebbbFormBundle:Form')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Form entity.');
        }


        // Create an array of the current Field objects in the database
        $originalFields = array();
        foreach ($entity->getFields() as $field)
            $originalFields[] = $field;


        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm($this->get('webbb_form.form.type.form'), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            // filter $originalFields to contain tags no longer present
            foreach ($entity->getFields() as $field)
                foreach ($originalFields as $key => $toDel)
                    if ($toDel->getId() === $field->getId())
                        unset($originalFields[$key]);
            // remove the relationship between the field and the Task
            foreach ($originalFields as $field) {
                // remove the Task from the Field
                // MTM: $entity->getFields()->removeElement($entity);
                // MTM:
                $field->setForm(null);
                // $em->persist($field);
                // if you wanted to delete the Field entirely, you can also do that
                $em->remove($field);
            }


            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('form_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Form entity.
     *
     * @Route("/{id}", name="form_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('WebbbFormBundle:Form')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Form entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('form'));
    }

    /**
     * Creates a form to delete a Form entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
