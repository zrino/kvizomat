<?php
namespace CoreBundle\Repository;


use Doctrine\ORM\EntityRepository;

class QuizRepository extends EntityRepository
{
    public function findByQuizAndSection($quiz_slug, $id_section)
    {
        $sql = "SELECT s.* FROM quiz_sections s INNER JOIN quiz q ON q.id = s.id_quiz WHERE s.id = :id_section AND q.slug = :quiz_slug";

        $stmt =  $this->getEntityManager()
            ->getConnection()->prepare($sql);
        $stmt->execute(['id_section' => $id_section, 'quiz_slug' => $quiz_slug]);
        return $stmt->fetchAll();
    }
}
