<?php
/**
 * Created by PhpStorm.
 * User: antho
 * Date: 08/04/2017
 * Time: 11:51
 */

namespace CoreAppBundle\ClassGestion;


use CoreAppBundle\InfoClass\Construct;
use CoreAppBundle\InfoClass\ContentClass;
use CoreAppBundle\InfoClass\InfoClass;
use CoreAppBundle\InfoClass\Methode;
use CoreAppBundle\InfoClass\Parameter;
use CoreAppBundle\InfoClass\Property;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Collections\ArrayCollection;

class Loader
{
    /** @var  InfoClass $InfoClass */
    private $InfoClass;

    /** @var  \ReflectionClass $reflexionCLass */
    private $reflexionCLass;

    private $class;

    /** @var ContentClass $classContent */
    private $contentClass;

    private $phpDocHeader;

    private $phpDocClass;

    /** @var ArrayCollection $uses */
    private $uses;

    /** @var  Construct $construct */
    private $construct;

    /** @var  ArrayCollection $properties */
    private $properties;

    /** @var  ArrayCollection $functions */
    private $methodes;
    

    /**
     * Loader constructor.
     */
    public function __construct(InfoClass $infoClass,$exist)
    {

        $this->contentClass = new ContentClass();
        $this->properties = new ArrayCollection();
        $this->uses = new ArrayCollection();
        $this->methodes = new ArrayCollection();
        $this->InfoClass = $infoClass;
        $className = $infoClass->getNamespace()."\\".$infoClass->getClassName();
        if($exist == true)
        {
            $this->class = new $className();
            $this->reflexionCLass = new \ReflectionClass($this->class);
            $this->phpDocClass = $this->reflexionCLass->getDocComment();
            $this->contentClass->setContent(file_get_contents(__DIR__."..\\..\\..\\".$className . ".php"));
            $this->annotationReader = new AnnotationReader();
            $this->loadUse();
            $this->loadConstruct();
            $this->loadPhpDocHeader();
            $this->loadProperty();
            $this->loadMethodes();
            $this->loadExtend();
        }
        else
        {
            $construct = new Construct();
            $this->setConstruct($construct);
        }

    }

    public function loadPhpDocHeader()
    {
        $phpDocHeader = explode("namespace",$this->contentClass->getContent())[0];
        $phpDocHeader = trim(explode("<?php",$phpDocHeader)[1]);
        $this->phpDocHeader = $phpDocHeader;
    }

    public function loadConstruct()
    {
        $this->construct = new Construct();
        $this->construct->setPhpDoc($this->reflexionCLass->getConstructor()->getDocComment());
        $this->construct->setContent($this->loadContentFunction("__construct"));

    }

    public function loadContentFunction($functionName)
    {
        // have problem when generate constructeur if parent construct;
        $functionName = "function ".$functionName;
        $content = explode($functionName,$this->contentClass->getContent())[1];
        $content = explode("{",$content);
        // because we have parameter in zero
        $countEndFunction = 1;
        $loop = 1;
        $return = "";
        while(true)
        {

            if(substr_count($content[$loop],"}") >= $countEndFunction)
            {
                $explode = explode("}",$content[$loop]);
                array_pop($explode);
                if(substr_count($content[$loop],"}") > $countEndFunction)
                {
                    array_pop($explode);
                }
                $return .= implode("}",$explode);
                return $return;
            }
            else
            {
                $return .= $content[$loop]. "{";
                $countEndFunction = $countEndFunction - substr_count($content[$loop],"}") + 1;
                $loop++;
            }
        }
    }

    private function loadUse()
    {
        $content = $this->contentClass->getContent();
        $content = explode("class ".$this->InfoClass->getClassName(), $content);
        $content = $content[0];
        $content = explode(";",$content);
        foreach($content as $contenu)
        {
            if(strstr($contenu,"use "))
            {
                $use = trim($contenu).";";
                $this->addUse($use);
            }
        }
    }
    public function loadProperty()
    {
        foreach($this->reflexionCLass->getProperties() as $propertyReflexion)
        {
            $property = new Property();
            $modifiers = \Reflection::getModifierNames($propertyReflexion->getModifiers());
            $property->setModifier(implode(" ",$modifiers));
            $property->setPhpdoc($propertyReflexion->getDocComment());
            $property->setPropertyName($propertyReflexion->getName());
            $this->properties->add($property);
        }
    }

    public function loadMethodes()
    {

        foreach($this->reflexionCLass->getMethods() as $methodsReflexion)
        {
            if($methodsReflexion->getDeclaringClass()->getName() == "AppBundle\\Entity\\".$this->InfoClass->getClassName())
            {
                if($methodsReflexion->getName() != "__construct")
                {
                    $methode = new Methode();
                    $methode->setMethodeName($methodsReflexion->getName());
                    $methode->setPhpdoc($methodsReflexion->getDocComment());
                    $modifiers = \Reflection::getModifierNames($methodsReflexion->getModifiers());
                    $methode->setModifier(implode(" ",$modifiers));
                    foreach ($methodsReflexion->getParameters() as $parameterReflexion)
                    {
                        /** TODO take back the type of parameters if exist */
                        $parameter = new Parameter();
                        $parameter->setName($parameterReflexion->getName());
                        $methode->addParameters($parameter);
                    }
                    $methode->setContent($this->loadContentFunction($methode->getMethodeName()));
                    $this->methodes->add($methode);
                }
                else
                {
                    foreach ($methodsReflexion->getParameters() as $parameterReflexion)
                    {
                        /** TODO take back the type of parameters if exist */
                        $parameter = new Parameter();
                        $parameter->setName($parameterReflexion->getName());
                        $this->construct->addParameters($parameter);
                    }
                }
            }
        }
    }

    public function loadExtend()
    {
        if($this->reflexionCLass->getParentClass() != null)
        {
            $extend = $this->reflexionCLass->getParentClass()->getName();
            $extend = explode("\\",$extend);
            $extend = array_pop($extend);
            $this->InfoClass->addExtends($extend);
        }

    }


    public function addUse($use)
    {
        $uses = explode("\\",$use);

        $useMaj = array();
        foreach ($uses as $use) {
            if($use == $uses[0])
            {
                $useMaj[] = $use;
            }
            else
            {
                $useMaj[] = ucfirst($use);
            }
        }
        $use = implode("\\",$useMaj);
        if(!$this->getUse()->contains($use))
        {
            $this->uses->add($use);
        }

    }
    public function getUse()
    {
        return $this->uses;
    }
    public function deleteUse($use)
    {
        $this->uses->remove($use);
    }


    public function addProperty(Property $property)
    {
        $this->properties->add($property);
    }
    public function getProperties()
    {
        return $this->properties;
    }
    public function deleteProperty(Property $property)
    {
        $this->properties->remove($property);
    }

    public function addMethode(Methode $methode)
    {
        $this->methodes->add($methode);
    }
    public function getMethodes()
    {
        return $this->methodes;
    }
    public function deleteMethode(Methode $methode)
    {
        $this->methodes->remove($methode);
    }

    /**
     * @return Construct
     */
    public function getConstruct()
    {
        return $this->construct;
    }

    /**
     * @param Construct $construct
     */
    public function setConstruct($construct)
    {
        $this->construct = $construct;
    }

    /**
     * @return \ReflectionClass
     */
    public function getReflexionCLass()
    {
        return $this->reflexionCLass;
    }

    /**
     * @param \ReflectionClass $reflexionCLass
     */
    public function setReflexionCLass($reflexionCLass)
    {
        $this->reflexionCLass = $reflexionCLass;
    }

    /**
     * @return mixed
     */
    public function getClass()
    {
        return $this->class;
    }







}