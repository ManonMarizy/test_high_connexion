<?php

namespace App\Controller;

use App\Repository\DonationRepository;
use App\Repository\UserLocationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    /**
     * @Route("/dashboard", methods={"GET"}, name="dashboard")
     * @param DonationRepository $donationRepository
     * @param UserLocationRepository $userLocationRepository
     * @return Response
     */
    public function index(DonationRepository $donationRepository, UserLocationRepository $userLocationRepository): Response
    {
        $tenDepartmentsPeople = array_merge(array_column($userLocationRepository->getStatisticsPerDepartment()['tenDepartments'], 'nbOfPeople'), array_column($userLocationRepository->getStatisticsPerDepartment()["otherDepartments"], 'nbOfPeople'));
        $tenDepartmentsNumber = array_column($userLocationRepository->getStatisticsPerDepartment()['tenDepartments'], 'departments');
        $tenDepartmentsNumber[] = "Autres";

        return $this->render('dashboard/index.html.twig', [
            'donationsAmount' => json_encode(array_column($donationRepository->getCountOfPeoplePerAmount(), 'total_amount')),
            'nbOfPeopleDonations' => json_encode(array_column($donationRepository->getCountOfPeoplePerAmount(), 'nbOfPeople')),
            'tenDepartmentsCountPeople' => json_encode($tenDepartmentsPeople),
            'tenDepartmentsNumbers' => json_encode($tenDepartmentsNumber),
        ]);
    }
}