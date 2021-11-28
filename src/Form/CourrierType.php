<?php

namespace App\Form;

use App\Entity\Courrier;
use App\Entity\Destinataire;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class CourrierType extends AbstractType
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ->add('id', HiddenType::class, [
            //     'required' => false
            // ])
            ->add('objet')
            ->add('destinataire', EntityType::class, [
                'class' => Destinataire::class,
                'placeholder' => '--Choisissez un destinataire--',
                'query_builder' => function (EntityRepository $er) 
                {
                    $user = $this->security->getUser();
                    return $er->createQueryBuilder('qb')
                        ->where('qb.utilisateur = :user')
                        ->setParameter('user', $user)
                        ->addOrderBy('qb.denomination', 'ASC')
                        ->addOrderBy('qb.prenom', 'ASC')
                        ->addOrderBy('qb.nom', 'ASC');
                },
            ])           
            ->add('dateEnvoi', DateType::class, [
                'widget' => 'single_text',
                'input_format' => 'd-M-Y',
                'required' => false
            ])
            ->add('dateRelance', DateType::class, [
                'widget' => 'single_text',
                'input_format' => 'd-M-Y',
                'required' => false
            ])
            ->add('statut', ChoiceType::class, [
                'placeholder' => "--Choisissez un statut--",
                'choices' => [
                    'Brouillon' => 'Brouillon',
                    'Sélectionné' => 'Sélectionné',
                    'Envoyé' => 'Envoyé'
                ],
            ])
            ->add('offreReference', TextType::class, [
                'required' => false
            ])
            ->add('nosReferences', TextType::class, [
                'required' => false
            ])
            ->add('vosReferences', TextType::class, [
                'required' => false
            ])
            ->add('paragraphe1', TextareaType::class, [
                'label' => false,
                'attr' => ['placeholder' => 'Dévrivez votre paragraphe "JE"...',
                    'rows' => 5,
                    'style' => 'resize: none;'],
            ])
            ->add('paragraphe2', TextareaType::class, [
                'label' => false,
                'attr' => ['placeholder' => 'Dévrivez votre paragraphe "VOUS"...',
                    'rows' => 5,
                    'style' => 'resize: none;'],
            ])
            ->add('paragraphe3', TextareaType::class, [
                'label' => false,
                'attr' => ['placeholder' => 'Dévrivez votre paragraphe "NOUS"...',
                    'rows' => 5,
                    'style' => 'resize: none;'],
            ])
            ->add('paragraphe4', TextareaType::class, [
                'label' => false,
                'attr' => ['placeholder' => 'Entrez votre formule de politesse...',
                    'rows' => 5,
                    'style' => 'resize: none;'],
            ]) 
            ->add('annonceCopie', TextareaType::class, [
                'required' => false,
                'label' => false,
                'attr' => ['placeholder' => 'Copier le texte de l\'offre de stage/d\'emploi...',
                    'rows' => 20,
                    'style' => 'resize: none;'],
            ]) 
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Courrier::class,
        ]);
    }
}
