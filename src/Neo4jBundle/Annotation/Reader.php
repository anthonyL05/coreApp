<?php
/**
 * Created by PhpStorm.
 * User: antho
 * Date: 16/01/2017
 * Time: 21:01
 */

namespace Neo4jBundle\Annotation;





use Doctrine\Common\Annotations\AnnotationReader;
use Neo4jBundle\Ogm\Atribut;
use Neo4jBundle\Ogm\Label;
use Neo4jBundle\Ogm\Node;
use Neo4jBundle\Repository\Repository;
use Neo4jBundle\Repository\RepositoryInfo;

class Reader
{


    public function __construct()
    {

    }

    public function getLabelEntity(RepositoryInfo $repositoryInfo)
    {
        $reader = new AnnotationReader();
        $readerClassAnnotation = $reader->getClassAnnotation($repositoryInfo->getReflexionClass(), 'Neo4jBundle\Annotation\AnnotationClass');
        /** TODO check if the readerClassAnnotation is not empty else return exeption */
        $label = new Label();
        /** TODO check if the value is possible */
        $label->setValue($readerClassAnnotation->label);
        return $label;
    }

    public function get($entity,RepositoryInfo $repositoryInfo)
    {
        // on cree la node a remplir
        $node = new Node();
        $node = $this->creeNodeClass($node,$entity,$repositoryInfo);
        return $node;





    }

    public function creeNodeClass(Node $node,$entity,RepositoryInfo$repositoryInfo)
    {
        $reader = new AnnotationReader();
        $readerClassAnnotation = $reader->getClassAnnotation($repositoryInfo->getReflexionClass(), 'Neo4jAccesBundle\Annotation\AnnotationClass');
        $label = $this->getLabelEntity($repositoryInfo);
        $node->addLabel($label);
        foreach($repositoryInfo->getReflexionClass()->getProperties() as $property)
        {
            $readerProperty = $reader->getPropertyAnnotation($property, 'Neo4jBundle\Annotation\AnnotationProperty');
            if($readerProperty) {
                $node = $this->getPropriete($readerProperty,$property,$repositoryInfo->getReflexionClass(),$entity,$node);

            }
        }
        return $node;
    }


    public function getPropriete($readerProperty ,$property,\ReflectionClass $reflexionClass,$entity,Node $node)
    {
        $atribut = new Atribut();
        $atribut->setName($readerProperty->name);
        $propertyName = $property->getName();
        /** Todo check if $nomMethode is ok (need to be in the entity) */
        $methodeName = $reflexionClass->getMethod("get" . $propertyName)->getName();
        $propertyValue = $entity->$methodeName();

        if($propertyValue == null)
        {
            if($readerProperty->nullable == true)
            {
                $atribut->setValue($propertyValue);
            }
            else
            {
                /**
                 * TODO Exeption this value of the attribute cant be null
                 */
            }
        }
        else
        {
            $atribut->setValue($propertyValue);
        }
        if($atribut->isTypeValid($readerProperty->type))
        {
            $atribut->setType($readerProperty->type);
        }
        else
        {
            $atribut->setType("string");
        }
        $node->addAtribut($atribut);
        return $node;

    }

}