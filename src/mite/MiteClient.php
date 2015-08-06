<?php
namespace drieschel\mite;
/**
 * @author Immanuel Klinkenberg <klinkenberg@speicher-werk.de>
 */
class MiteClient
{
  /**
   * @var \Pest
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
   * @param string $apiKey
   * @param string $baseUrl
   */
  function __construct($apiKey, $baseUrl = '')
  {
    $this->apiKey = $apiKey;
    $this->baseUrl = $baseUrl;
  }
  
  public function getCustomer($id)
  {
    return $this->pest->
  }

}
