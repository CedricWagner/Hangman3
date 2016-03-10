<?php

namespace AppBundle\Controller;

use AppBundle\Form\Domain\Contact;
use AppBundle\Form\Type\ContactType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ContactController extends Controller
{
    /**
     * @Route("/contact", name="contact_us")
     * @Method({ "GET", "POST" })
     */
    public function contactAction(Request $request)
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->add('submit', SubmitType::class);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $body = $this->renderView('contact/contact.txt.twig', [ 'contact' => $contact ]);
            $message = $contact->createMessage('admin@mywebsite.tld', $body);
            $this->get('mailer')->send($message);

            return $this->redirect($this->generateUrl('contact_us'));
        }

        return $this->render('contact/contact.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}
