<?php
namespace drieschel\mite;
/**
 * @author Immanuel Klinkenberg <klinkenberg@speicher-werk.de>
 */
class MiteClient
{
  /**
   * @var \PestJSON
   */
  protected $pest;
  
  /**
   * @var string
   */
  protected $apiKey;
  
  /**
   * @var string
   */
  protected $baseUrl;
  
  /**
   * @var string
   */
  protected $responseFormat = 'json';
  
  /**
   * @param string $apiKey
   * @param string $miteUrl
   * @param string $responseFormat
   */
  function __construct($apiKey, $miteUrl, $responseFormat = 'json')
  {
    $this->apiKey = $apiKey;
    $this->baseUrl = $miteUrl;
    
    if(!in_array($responseFormat, array('json')))
    {
      throw new \Exception($responseFormat . ' is not a valid response format');
    }    
    $this->responseFormat = $responseFormat;    
    $this->pest = new \PestJSON($miteUrl);
  }
  
  /**
   * @param integer $id
   * @return mixed
   */
  public function getCustomer($id)
  {
    return $this->get('customers/' . $id, array(), array(), true);
  }
  
  /**
   * @param integer $id
   * @return mixed
   */
  public function getProject($id)
  {
    return $this->get('projects/' . $id, array(), array(), true);
  }
  
  /**
   * @param array $parameters
   * @return mixed
   */
  public function getProjectsBy(array $parameters = array())
  {
    return $this->get('projects', $parameters);
  }
  
  /**
   * @param integer $customerId
   * @return mixed
   */
  public function getProjectsByCustomer($customerId)
  {
    return $this->getProjectsBy(array('customer_id' => $customerId));
  }
  
  /**
   * @param array $parameters
   * @return mixed
   */
  public function getTimeEntriesBy(array $parameters)
  {
    return $this->get('time_entries', $parameters);
  }
  
  /**
   * @param integer $projectId
   * @return mixed
   */
  public function getTimeEntriesByProject($projectId)
  {
    return $this->getTimeEntriesBy(array('project_id' => $projectId));    
  }

  /**
   * @param string $url
   * @param array $data
   * @param array $headers
   * @param boolean $singleEntry
   */
  protected function get($url, array $data = array(), array $headers = array(), $singleEntry = false)
  {
    $data['api_key'] = $this->apiKey;
    $response = $this->pest->get($url . '.' . $this->responseFormat, $data, $headers);    
    $elementsCount = count($response);    
    if($elementsCount == 1)
    {
      return $singleEntry ? array_pop($response) : array(0 => array_pop($response));
    }
    else if ($elementsCount > 1)
    {
      $resorted = array();
      foreach($response AS $i => $data)
      {
        $resorted[$i] = array_pop($data);
      }
      return $resorted;
    }
    return array();
  }
}
