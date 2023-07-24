<?php
declare(strict_types=1);
namespace App\Responder;

use App\Domain\Entity\Product;
use App\Enum\BillingsEnum;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Forms;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment as TwigEnvironment;

/**
 *
 */
final class HomepageResponder extends AbstractType
{

    /**
     * @param ManagerRegistry $managerRegistry
     * @param TwigEnvironment $twig
     */
    public function __construct(
        private ManagerRegistry       $managerRegistry,
        private TwigEnvironment       $twig,
    ) {}

    /**
     * @return Response
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function __invoke(): Response
    {
        $formFactory = Forms::createFormFactory();
        $form = $formFactory->createBuilder()
            ->add('product', ChoiceType::class, $this->createProduct())
            ->add('taxNumber', TextType::class)
            ->add('couponCode', TextType::class)
            ->add('paymentProcessor', ChoiceType::class, [
                'choices'  => BillingsEnum::BILLINGS
            ])
            ->add('calculate', ButtonType::class)
            ->add('money', TextType::class)
            ->add('buy', ButtonType::class)
            ->getForm();

        return new Response($this->twig->render('home.html.twig', [
                'form' => $form->createView(),
            ])
        );
    }

    /**
     * @return array[]
     */
    protected function createProduct(): array
    {
        $products = $this->managerRegistry
            ->getRepository(Product::class)
            ->findAll();

        $options = [];
        foreach ($products as $product) {
            $options[$product->getName()] = $product->getId();
        }

        return ['choices' => $options];
    }
}
