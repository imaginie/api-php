<?php
namespace ApiClient;

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

  protected $_login;
  protected $_password;
  private $_token;
  protected $_http_status;
  protected $_http_error;

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
  public function __construct($username_or_token=null, $password=null)
  {
    $this->_username = $password ? $username_or_token : null;
    $this->_password = $password;
    $this->_token = $password ? null : $username_or_token;
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
    $result = curl_exec($curl);
    $this->_http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    if (curl_error($curl))
    {
      $this->_http_error = curl_error($curl);
    }
    if(!$result)
    {
      var_dump($result);
      var_dump($this->_http_status);
      var_dump($this->_http_error);
      die('Connection Failure');
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
    $token = $this->_call('POST', self::AUTH_URL, $data);
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
    return $this->_call('POST', $url, $data);
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
    return $this->_call('PATCH', $url, $data);
  }

  public function deleteStudent($id)
  {
    $url = self::BASE_URL . '/students/' . $id;
    return $this->_call('DELETE', $url);
  }

  public function getClasses()
  {
    $url = self::BASE_URL . '/classes';
    return $this->_call('GET', $url);
  }

  public function getClass($id)
  {
    $url = self::BASE_URL . '/classes/' . $id;
    return $this->_call('GET', $url);
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
    return $this->_call('POST', $url, $data);
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
    return $this->_call('PATCH', $url, $data);
  }

  public function deleteClass($code)
  {
    $url = self::BASE_URL . '/classes/' . $code;
    return $this->_call('DELETE', $url);
  }

  public function getAssessments()
  {
    $url = self::BASE_URL . '/assessments';
    return $this->_call('GET', $url);
  }

  public function getAssessment($id)
  {
    $url = self::BASE_URL . '/assessments/' . $id;
    return $this->_call('GET', $url);
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
    return $this->_call('POST', $url, $data);
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
    return $this->_call('PATCH', $url, $data);
  }

  public function deleteAssessment($id)
  {
    $url = self::BASE_URL . '/assessments/' . $id;
    return $this->_call('DELETE', $url);
  }

  public function getAssessmentEssays($class_code, $assessment_id)
  {
    $url = self::BASE_URL . '/schools/' . $class_code . '/assessments/' . $assessment_id;
    return $this->_call('GET', $url);
  }

  public function getStudentEssays($student_code, $essay_status=null)
  {
    $url = self::BASE_URL . '/students/' . $student_code . '/essays';
    if ($essay_status)
    {
      $url .= '?status=' . $essay_status;
    }
    return $this->_call('GET', $url);
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
    return $this->_call('POST', $url, $data);
  }
}