/**
* 1. Run: sudo composer require jms/serializer-bundle
* 2. In AppKernel::registerBundles() add: new JMS\SerializerBundle\JMSSerializerBundle(),
*/

namespace RestUtils\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class RestController extends Controller {
	
    /**
     * Converts the entity with id $id of the class $class to JSON format
     */
    public function serializeOneToJson($class, $id) {
        return $this->toJsonResponse($this->getEntityData($id, $class));
    }

    /**
     * Converts all entities of the class $class to JSON format
     */
    public function serializeAllToJson($class) {
		return $this->toJsonResponse($this->getAllData());
    }
	
    /**
     * Converts the entity with id $id of the class $class to XML format
     */
    public function serializeOneToXml($class, $id) {
        return $this->toJsonResponse($this->getEntityData($id, $class));
    }

    /**
     * Converts all entities of the class $class to XML format
     */
    public function serializeAllToXml($class) {
        return $this->toXmlResponse($this->getAllData());
    }
	
	/**
	* Returns all entities of the class $class
	*/
	private function getAllData($class) {
        $entityManager = $this->getDoctrine()->getManager();
        return $entityManager->getRepository($class)->findAll();
	}
	
	/**
	* Returns the entity with id $id of the class $class
	*/
	private function getEntityData($id, $class) {
        $entityManager = $this->getDoctrine()->getManager();
        return $entityManager->getRepository($class)->findOneBy(array('id' => $id));
	}
	
    /**
     * Converts data to a JSON response
     * @param $data
     * @return Response
     */
    public function toJsonResponse($data) {
        $serializer = $this->container->get('jms_serializer');
        $jsonContent = $serializer->serialize($data, 'json');
        return new Response($jsonContent);
    }
	
    /**
     * Converts data to an XML response
     * @param $data
     * @return Response
     */
    public function toXmlResponse($data) {
        $serializer = $this->container->get('jms_serializer');
        $xmlContent = $serializer->serialize($data, 'xml');
        return new Response($xmlContent);
    }
}