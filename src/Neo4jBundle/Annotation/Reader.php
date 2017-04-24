<?php
/**
 * Created by PhpStorm.
 * User: antho
 * Date: 16/01/2017
 * Time: 21:01
 */

namespace Neo4jBundle\Annotation;





use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Collections\ArrayCollection;
use GraphAware\Neo4j\Client\Formatter\RecordView;
use Neo4jBundle\Ogm\Atribut;
use Neo4jBundle\Ogm\Label;
use Neo4jBundle\Ogm\Node;
use Neo4jBundle\Repository\Repository;
use Neo4jBundle\Repository\RepositoryInfo;
use Neo4jBundle\Service\Connection;

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

    public function get($entity,RepositoryInfo $repositoryInfo,Connection $connection)
    {
        // on cree la node a remplir
        $node = new Node();
        $node = $this->creeNodeClass($node,$entity,$repositoryInfo,$connection);
        return $node;
    }

    public function creeNodeClass(Node $node,$entity,RepositoryInfo $repositoryInfo,Connection $connection)
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
        foreach ($entity->getClass() as $entityPossible)
        {
            $entityName = explode('\\',get_class($entityPossible));
            $entityName =array_pop($entityName);
            $repository = new Repository($entityName,$connection);
            $node = $this->creeNodeClass($node,$entityPossible,$repository->getRepositoryInfo(),$connection);
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

    public function getResult(RecordView $nodeResult , RepositoryInfo $repositoryInfo,$type)
    {
        /**
         * TODO check the type "find all ..."
         */
        /** @var  \GraphAware\Neo4j\Client\Formatter\Type\Node $nodeValue */
        $propertyFind = new ArrayCollection();
        $nodeValue = $nodeResult->values()[0];
        $className = "AppBundle\\Entity\\".$repositoryInfo->getEntityName();
        $entity = new  $className;
        foreach ($nodeValue->asArray() as $propertyNameReel  => $property)
        {
            $propertyName = $this->getPropertyName($propertyNameReel,$repositoryInfo->getReflexionClass());
            if($repositoryInfo->getReflexionClass()->hasMethod("set" . $propertyName) != null)
            {
                $methodeName =$repositoryInfo->getReflexionClass()->getMethod("set" . $propertyName)->getName();
                $entity->$methodeName($property);
            }
            else
            {
                $propertyFind->add(array($property,$propertyNameReel));
            }
        }
        if(count($propertyFind) > 0)
        {
            /** @var \GraphAware\Neo4j\Client\Formatter\Type\Node $resultNode */
            $resultNode = $nodeResult->values()[0];
            $labels = $resultNode->labels();
            foreach ($labels as $label)
            {
                if($label != $repositoryInfo->getEntityName())
                {
                    $className = "AppBundle\\Entity\\".$label;
                    $entityPossible = new $className;
                    $reflexionClass = new \ReflectionClass($entityPossible);
                    foreach ($propertyFind as $property)
                    {
                        $propertyName = $this->getPropertyName($property[1],$reflexionClass);
                        if($reflexionClass->hasMethod("set" . $propertyName) != null)
                        {
                            $methodeName =$reflexionClass->getMethod("set" . $propertyName)->getName();
                            $entityPossible->$methodeName($property[0]);
                            $entity->addClass($entityPossible);
                        }
                    }
                }
            }
        }
        return $entity;
    }

    public function getPropertyName($propertyNameReel, \ReflectionClass $reflectionClass)
    {
        $reader = new AnnotationReader();
        foreach($reflectionClass->getProperties() as $property) {
            $readerProperty = $reader->getPropertyAnnotation($property, 'Neo4jBundle\Annotation\AnnotationProperty');
            if ($readerProperty) {
                if($readerProperty->name == $propertyNameReel)
                {
                    $propertyName = $property->getName();
                }

            }
        }
        if(isset($propertyName))
        {
            return $propertyName;
        }
        else
        {
            /**
             * TODO the property didnt exist its maybe in contains class or an other property
             */
        }

    }


}