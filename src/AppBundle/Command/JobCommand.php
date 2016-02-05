<?php

namespace AppBundle\Command;

use AppBundle\Entity\Job;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class JobCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:job:show')
            ->setDescription('Show list of jobs for given user')
            ->addArgument(
                'user',
                InputArgument::REQUIRED,
                'user whose jobs will be listed'
            )
            ->addOption(
                'published',
                null, // shortcut
                InputOption::VALUE_NONE,
                'show only published'
            )
            ->addOption(
                'limit',
                null,
                InputOption::VALUE_OPTIONAL,
                'limit job list'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $username = $input->getArgument('user');
        $user = $this->getContainer()->get('repository.user')
            ->findOneBy(['username' => $username]);

        if (!$user) {
            $output->writeln('<error>User with given username does not exist</error>');
            return;
        }

        $limit = $input->getOption('limit');
        $published = $input->getOption('published');

        $jobs = $this->findJobsForUserWithParameters($user, $published, $limit);

        if (empty($jobs)) {
            $output->writeln('<info>No jobs found</info>');
            return;
        }

        $table = new Table($output);
        $table->setHeaders(['title', 'employer', 'description', 'type']);

        $rows = $this->convertJobArrayToTableRows($jobs);
        $table->setRows($rows);

        $table->render();
    }

    /**
     * @param User $user
     * @param bool $published
     * @param int $limit
     *
     * @return Job[]
     */
    private function findJobsForUserWithParameters(User $user, $published, $limit)
    {
        $qb = $this->getContainer()->get('doctrine.orm.entity_manager')
            ->getRepository('AppBundle:Job')
            ->createQueryBuilder('j')
            ->select('j')
            ->where('j.author = :author')
            ->setParameter('author', $user);

        if ($published) {
            $qb = $qb->andWhere('j.publishedAt is not null');
        }

        if (filter_var($limit, FILTER_VALIDATE_INT) !== false) {
            $qb->setMaxResults($limit);
        }

        return $qb
            ->getQuery()
            ->getResult();
    }

    /**
     * @param Job[] $jobs
     *
     * @return array
     */
    protected function convertJobArrayToTableRows(array $jobs)
    {
        $rows = [];
        foreach ($jobs as $job) {
            $rows[] = [
                $job->getTitle(),
                $job->getEmployer(),
                substr($job->getDescription(), 0, 150),
                $job->getType()->getName()
            ];
        }

        return $rows;
    }
}
