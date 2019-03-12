<?php
namespace ApiClient;
use Exception;

error_reporting(E_ALL);
ini_set('display_errors', 1);

/**
 * Imaginie API Client
 * 
 * Imaginie PHP API Client
 * 
 * @author Imaginie
 * 
 * @since 1.0
 */
class Imaginie
{
  const BASE_URL = 'https://app.imaginie.com/api/v3';
  const AUTH_URL = 'https://app.imaginie.com/api/api-token-auth/';

  protected $_username;
  protected $_password;
  private $_token;
  protected $_http_status;
  protected $_http_error;
  private $_retry;
  private $_response;

  /**
   * Class constructor
   * 
   * @author Imaginie
   * 
   * @since 1.0
   * 
   * @param string username_or_token The username for login or JWT token
   * @param string password username password. Use only if you are not using token on the first param
   */
  public function __construct($username, $password, $token=null)
  {
    $this->_username = $username;
    $this->_password = $password;
    $this->_token = $token ? $token : null;
    $this->_retry = true;
    $this->_response = [
      'headers' => [],
      'body' => []
    ];
  }

  public function setResponseHeaders($headers)
  {
    $this->_response['headers'] = $headers;
  }

  public function setResponseBody($body)
  {
    $this->_response['body'] = $body;
  }

  public function getResponse()
  {
    return $this->_response;
  }

  public function getResponseHeaders()
  {
    return $this->_response['headers'];
  }

  public function getResponseBody()
  {
    return $this->_response['body'];
  }

  protected function _call($method, $url, $data=[])
  {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_FAILONERROR, true);

    switch ($method)
    {
      case 'POST':
        curl_setopt($curl, CURLOPT_POST, 1);
        break;

      case 'PUT':
      case 'DELETE':
      case 'UPDATE':
      case 'PATCH':
      case 'RETRIEVE':
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        break;
    }

    if (is_array($data) && count($data))
    {
      if ($method == 'GET')
      {
        $url = sprintf('%s?%s', $url, http_build_query($data));
      }
      else
      {
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
      }
    }

    $headers = [
      'Content-Type: application/json'
    ];

    $token = $this->getToken();
    if ($token)
    {
      $headers[] = 'Authorization: JWT ' . $token;
    }

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

    $response_headers = [];
    curl_setopt($curl, CURLOPT_HEADERFUNCTION,
      function($curl, $response_header) use (&$response_headers)
      {
        $len = strlen($response_header);
        $response_header = explode(':', $response_header, 2);
        if (count($response_header) < 2)
        {
          return $len;
        }

        $name = strtolower(trim($response_header[0]));
        if (!array_key_exists($name, $response_headers))
        {
          $response_headers[$name] = [trim($response_header[1])];
        }
        else
        {
          $response_headers[$name][] = trim($response_header[1]);
        }
        return $len;
      }
    );

    $result = curl_exec($curl);
    $this->_http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    if (curl_error($curl))
    {
      $this->_http_error = curl_error($curl);
    }

    $this->setResponseHeaders($response_headers);
    $this->setResponseBody($result);

    if(!$result)
    {
      if ($this->_http_status === 401 && $this->_retry === true)
      {
        $this->_retry = false;
        $this->login();
        return $this->_call($method, $url, $data);
      }

      $error_message = 'HTTP STATUS: ' . $this->_http_status;
      $error_message .= ' - HTTP ERROR: ' . $this->_http_error;
      throw new Exception($error_message);
    }
    curl_close($curl);
    return json_decode($result);
  }

  public function login()
  {
    $token = $this->getToken();
    if ($token)
    {
      return $token;
    }

    $data = [
      'username' => $this->_username,
      'password' => $this->_password
    ];
    try
    {
      $token = $this->_call('POST', self::AUTH_URL, $data);
    }
    catch (Exception $ex)
    {
      die('Username and/or password invalid');
    }

    $this->setToken($token->token);
    return $token->token;
  }

  public function getToken()
  {
    return $this->_token;
  }

  public function setToken($token)
  {
    $this->_token = $token;
  }

  public function getStudents()
  {
    $url = self::BASE_URL . '/students';
    return $this->_call('GET', $url);
  }

  public function getStudent($id)
  {
    $url = self::BASE_URL . '/students/' . $id;
    return $this->_call('GET', $url);
  }

  public function createStudent($name, $email, $code, $class_code=null)
  {
    $url = self::BASE_URL . '/students';
    $data = [
      'name' => $name,
      'email' => $email,
      'code' => $code
    ];
    if ($class_code)
    {
      $data['class_code'] = [$class_code];
    }

    try
    {
      $result = $this->_call('POST', $url, $data);
      return $result;
    }
    catch (Exception $ex)
    {
      throw new Exception($ex->getMessage());
    }
  }

  public function updateStudent($id, $name, $email, $code=null, $class_code=null)
  {
    $url = self::BASE_URL . '/students/' . $id;
    $data = [
      'name' => $name,
      'email' => $email
    ];
    if ($code)
    {
      $data['code'] = $code;
    }
    if ($class_code)
    {
      $data['class_code'] = [$class_code];
    }

    try
    {
      $result = $this->_call('PATCH', $url, $data);
      return $result;
    }
    catch (Exception $ex)
    {
      throw new Exception($ex->getMessage());
    }
  }

  public function deleteStudent($id)
  {
    $url = self::BASE_URL . '/students/' . $id;

    try
    {
      $result = $this->_call('DELETE', $url);
    }
    catch (Exception $ex)
    {
      throw new Exception($ex->getMessage());
    }
  }

  public function getClasses()
  {
    $url = self::BASE_URL . '/classes';

    try
    {
      $result = $this->_call('GET', $url);
    }
    catch (Exception $ex)
    {
      throw new Exception($ex->getMessage());
    }
  }

  public function getClass($id)
  {
    $url = self::BASE_URL . '/classes/' . $id;

    try
    {
      $result = $this->_call('GET', $url);
    }
    catch (Exception $ex)
    {
      throw new Exception($ex->getMessage());
    }
  }

  public function createClass($name, $description, $code, $parent_code=null)
  {
    $url = self::BASE_URL . '/classes';
    $data = [
      'name' => $name,
      'description' => $description,
      'code' => $code
    ];
    if ($parent_code)
    {
      $data['parent_code'] = [$parent_code];
    }

    try
    {
      $result = $this->_call('POST', $url, $data);
    }
    catch (Exception $ex)
    {
      throw new Exception($ex->getMessage());
    }
  }

  public function updateClass($code, $name, $description, $new_code=null, $parent_code=null)
  {
    $url = self::BASE_URL . '/classes/' . $code;
    $data = [
      'name' => $name,
      'description' => $description
    ];
    if ($new_code)
    {
      $data['new_code'] = $new_code;
    }
    if ($parent_code)
    {
      $data['parent_code'] = [$parent_code];
    }

    try
    {
      $result = $this->_call('PATCH', $url, $data);
    }
    catch (Exception $ex)
    {
      throw new Exception($ex->getMessage());
    }
  }

  public function deleteClass($code)
  {
    $url = self::BASE_URL . '/classes/' . $code;

    try
    {
      $result = $this->_call('DELETE', $url);
    }
    catch (Exception $ex)
    {
      throw new Exception($ex->getMessage());
    }
  }

  public function getAssessments()
  {
    $url = self::BASE_URL . '/assessments';

    try
    {
      $result = $this->_call('GET', $url);
    }
    catch (Exception $ex)
    {
      throw new Exception($ex->getMessage());
    }
  }

  public function getAssessment($id)
  {
    $url = self::BASE_URL . '/assessments/' . $id;

    try
    {
      $result = $this->_call('GET', $url);
    }
    catch (Exception $ex)
    {
      throw new Exception($ex->getMessage());
    }
  }

  public function createAssessment($theme_id, $drafts_available, $deadline, $class_code=null)
  {
    $url = self::BASE_URL . '/assessments';
    $data = [
      'theme_id' => $theme_id,
      'drafts_available' => $drafts_available,
      'deadline' => $deadline
    ];
    if ($class_code)
    {
      $data['class_code'] = [$class_code];
    }

    try
    {
      $result = $this->_call('POST', $url, $data);
    }
    catch (Exception $ex)
    {
      throw new Exception($ex->getMessage());
    }
  }

  public function updateAssessment($id, $theme_id, $drafts_available,
    $deadline=null, $class_code=null
  )
  {
    $url = self::BASE_URL . '/assessments/' . $id;
    $data = [
      'theme_id' => $theme_id,
      'drafts_available' => $drafts_available,
      'deadline' => $deadline
    ];
    if ($class_code)
    {
      $data['class_code'] = [$class_code];
    }

    try
    {
      $result = $this->_call('PATCH', $url, $data);
    }
    catch (Exception $ex)
    {
      throw new Exception($ex->getMessage());
    }
  }

  public function deleteAssessment($id)
  {
    $url = self::BASE_URL . '/assessments/' . $id;

    try
    {
      $result = $this->_call('DELETE', $url);
    }
    catch (Exception $ex)
    {
      throw new Exception($ex->getMessage());
    }
  }

  public function getAssessmentEssays($class_code, $assessment_id)
  {
    $url = self::BASE_URL . '/schools/' . $class_code . '/assessments/' . $assessment_id;

    try
    {
      $result = $this->_call('GET', $url);
    }
    catch (Exception $ex)
    {
      throw new Exception($ex->getMessage());
    }
  }

  public function getStudentEssays($student_code, $essay_status=null)
  {
    $url = self::BASE_URL . '/students/' . $student_code . '/essays';
    if ($essay_status)
    {
      $url .= '?status=' . $essay_status;
    }

    try
    {
      $result = $this->_call('GET', $url);
    }
    catch (Exception $ex)
    {
      throw new Exception($ex->getMessage());
    }
  }

  public function createEssay($student_code, $theme_id, $assessment_id,
    $request_correction, $school_correction, $image_url, $comments_required
  )
  {
    $url = self::BASE_URL . '/students/' . $student_code . '/essays';
    $data = [
      'theme' => $name,
      'assessment' => $email,
      'request_correction' => (bool) $request_correction,
      'school_correction' => (bool) $school_correction,
      'image_url' => $image_url,
      'comments_required' => (bool) $comments_required
    ];

    try
    {
      $result = $this->_call('POST', $url, $data);
    }
    catch (Exception $ex)
    {
      throw new Exception($ex->getMessage());
    }
  }
}