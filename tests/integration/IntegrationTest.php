<?php


namespace App\Tests\integration;

use App\Domain\Atm\AtmRepository;
use App\Domain\Management\HeadOfficeRepository;
use App\Domain\SnackMachine\Snack;
use App\Domain\SnackMachine\SnackMachineRepository;
use App\Domain\SnackMachine\SnackRepository;
use App\Kernel;
use Psr\Container\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class IntegrationTest extends KernelTestCase
{
    public function test_db_connection(): void
    {
        $snackMachine = $this->container
            ->get(SnackMachineRepository::class)
            ->find(1);

        $this->assertNotNull($snackMachine);
    }

    public function test_snack_reference_data(): void
    {
        $repository = $this->container->get(SnackRepository::class);
        $chocolate  = $repository->find(Snack::Chocolate()->getId());
        $soda       = $repository->find(Snack::Soda()->getId());
        $gum        = $repository->find(Snack::Gum()->getId());

        $this->assertEquals($chocolate->getName(), Snack::Chocolate()->getName());
        $this->assertEquals($soda->getName(), Snack::Soda()->getName());
        $this->assertEquals($gum->getName(), Snack::Gum()->getName());
    }

    public function test_atm_repository(): void
    {
        $atm = $this->container
            ->get(AtmRepository::class)
            ->find(1);

        $this->assertNotNull($atm);
    }

    public function test_head_office_repository(): void
    {
        $headOffice = $this->container
            ->get(HeadOfficeRepository::class)
            ->instance();

        $this->assertNotNull($headOffice);
    }

    public static $class = Kernel::class;

    /** @var ContainerInterface */
    private $container;

    protected function setUp()
    {
        $kernel          = self::bootKernel();
        $this->container = $kernel->getContainer();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }
}