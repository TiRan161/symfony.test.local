<?php


namespace App\Controller;


use App\Entity\Branch;
use App\Entity\Manager;
use Doctrine\Common\Collections\Criteria;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class GetDataController extends AbstractController
{
    private $conn;

    public function __construct(Connection $conn)
    {
        $this->conn = $conn;
    }

    public function getDataSql (Request $request, PaginatorInterface $paginator)
    {
        $manager = $this->getManagersSql();

    }

    public function getManagersSql()
    {
        $sql = 'select m.id as id, m.code as code, m.photo as photo, m.surname as surname, m.name as name, ';
        $sql.= 'm.middle_name as middleName, m.email as email, br.name as branch from manager m ';
        $sql.= 'left join branch br on br.id = m.branch_id';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $managers = [];
        while ($row = $stmt->fetch()) {
            $managers[] = $row;
        }
        return $managers;

    }

    public function getBranchSql()
    {
        $sql = 'select br.id as id, br.name as name from branch br';
    }

    public function getPersonaManagerSql($code)
    {
        $sql = 'select m.id as id, m.code as code, m.photo as photo, m.surname as surname, m.name as name,
                m.middle_name as middleName, m.email as email, br.name as branch  from manager m 
                left join branch br on br.id = m.branch_id where m.code = :code';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue('code', $code);
        $stmt->execute();
        $manager = $stmt->fetch();
        return $this->render('index/personalPage.html.twig', [
            'manager' => $manager,
        ]);

    }

    private function getManagersId()
    {
        $sql = 'select id from manager';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $arrID = [];
        while ($row = $stmt->fetch()){
            $arrID[] = $row['id'];
        }
        return $arrID;
    }


    public function getData(Request $request, PaginatorInterface $paginator)
    {
        $managers = $this->getManagers();
        $branch = $this->getBranch();
//        $managersSql = $this->getManagersSql();
//        $managersId = $this->getManagersId();
        $pagination = $paginator->paginate(
            $managers,
//            $managersId,
            $request->query->getInt('page', 1),
            5
        );
//        $managersIdOnPage = $pagination->getItems();
//        $managersWithId = $this->getManagersWithId($managersIdOnPage);
        return $this->render('index/getData.html.twig', [
            'pagination' => $pagination,
//            'managers' => $managersWithId,
            'managers' => $managers,
            'branches' => $branch,
        ]);
    }

    private function getManagersWithId($ids)
    {
        $sql = 'select m.id as id, m.code as code, m.photo as photo, m.surname as surname, m.name as name, ';
        $sql.= 'm.middle_name as middleName, m.email as email, m.branch_id as branchId, br.name as branchName from manager m ';
        $sql.= 'left join branch br on br.id = m.branch_id where m.id in (' . implode(',', $ids) . ') '; //!
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $managers = [];

        while ($row = $stmt->fetch()) {
            $managers[] = [
                'id' => $row['id'],
                'code' => $row['code'],
                'photo' => $row['photo'],
                'surname' => $row['surname'],
                'name' => $row['name'],
                'middleName' => $row['middleName'],
                'email' => $row['email'],
                'branch' => [
                    'id' => $row['branchId'],
                    'name' => $row['branchName'],
                ]
            ];
        }
        return $managers;


    }

    public function getQueryManagers()
    {
        /** @var EntityRepository $managersRepo */
        $em = $this->getDoctrine()->getManager();
        $managersRepo = $em->getRepository(Manager::class);
        $qb = $managersRepo->createQueryBuilder();
    }

    public function getManagers()
    {
        /** @var EntityRepository $managersRepo */
        $managersRepo = $this->getDoctrine()->getRepository(Manager::class);
        return $managersRepo->matching(Criteria::create()->orderBy(['id' => 'ASC']));
    }

    public function getBranch()
    {
        $branch = $this->getDoctrine()->getRepository(Branch::class)->findAll();
        return $branch;
    }

    public function getBranchManagers(Branch $branch)
    {
        $managers = $this->getDoctrine()->getRepository(Manager::class)->findBy([
            'branch' => $branch,
        ]);
        return $this->render('index/branchManagers.html.twig', [
            'managers' => $managers,
            'branch' => $branch,
        ]);
    }

    public function getPersonalManager(Manager $manager)
    {
        return $this->render('index/personalPage.html.twig', [
            'manager' => $manager,
        ]);
    }

}