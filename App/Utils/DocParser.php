<?php
namespace App\Utils;


class DocParser
{
    /**
     * @var ReflectionUtil
     * @onInit(App\Units\ReflectionUtil)
     */
    private $reflectionUtil;

    public function getClassAnnotatie(object $object, string $annotation)
    {
        $docComment = $this->reflectionUtil->getClassDocBlock($object);
        return $this->getAnnotationValue($annotation, $docComment, false);
    }

    public function toArray(string $docComment)
    {
        $docComment = str_replace(['/**', '*/'], '', $docComment);
        $docComment = trim($docComment);
        $docCommentArray = explode("\n", $docComment);

        $docCommentArray = array_map(function ($item) {
            $item = trim($item);

            $position = strpos($item, '*');
            if ($position === 0) {
                $item = substr($item, 1);
            }

            return trim($item);
        }, $docCommentArray);

        return $docCommentArray;
    }

    public function getAnnotationValue(string $annotation, string $docComment, bool $replaceQuotes = true)
    {
        $docCommentArray = $this->toArray($docComment);
        $annotateValue = null;

        foreach ($docCommentArray as $docCommentItem) {
            $annotationPrefix = $annotation . '("';
            $isHasAnnotate = strpos($docCommentItem, $annotationPrefix) === 0;

            if (!$isHasAnnotate) {
                continue;
            }

            $annotateValue = str_replace($annotationPrefix, '', $docCommentItem);
            $annotateValue = substr($annotateValue, 0, -1);

            if ($replaceQuotes && !empty($annotateValue)) {
                $annotateValue = substr($annotateValue, 0, -1);
            }

            break;
        }

        return $annotateValue;
    }

    /**
     * @param string $annotation
     * @param string $docComment
     * @return bool
     */
    public function isHasAnnotate(string $annotation,  string $docComment): bool
    {
        return strpos($docComment, $annotation) !== false;
    }
}