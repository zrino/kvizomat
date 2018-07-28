<?php

namespace CoreBundle\Quiz\Enum;

class QuestionTypeEnum
{
    public const QUESTION_WITH_OFFERED_ANSWERS = 1;
    public const QUESTION_WITH_FREE_INPUT = 2;
    public const QUESTION_WITH_LINKS = 3;

    public const QUESTION_TYPES = [
        self::QUESTION_WITH_OFFERED_ANSWERS,
        self::QUESTION_WITH_FREE_INPUT
    ];
}