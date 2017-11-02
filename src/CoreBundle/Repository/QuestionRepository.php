<?php
namespace CoreBundle\Repository;


use Doctrine\ORM\EntityRepository;

class QuestionRepository extends EntityRepository
{
    public function findByQuestionsGroupedBySections($sections)
    {
        $sectionsArray = array_map(function ($section) {
            return $section->getId();
        }, $sections);
        $sectionsString = implode(',', $sectionsArray);

        $sql = "SELECT q.id, q.id_section, q.question_text AS questionText FROM quiz_questions q WHERE  q.id_section IN (" . $sectionsString . ") ORDER BY q.id_section";

        $stmt =  $this->getEntityManager()
            ->getConnection()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
} 
