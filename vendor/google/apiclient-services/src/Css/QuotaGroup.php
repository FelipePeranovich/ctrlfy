<?php
/*
 * Copyright 2014 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may not
 * use this file except in compliance with the License. You may obtain a copy of
 * the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations under
 * the License.
 */

namespace Google\Service\Css;

class QuotaGroup extends \Google\Collection
{
  protected $collection_key = 'methodDetails';
  protected $methodDetailsType = MethodDetails::class;
  protected $methodDetailsDataType = 'array';
  /**
   * @var string
   */
  public $name;
  /**
   * @var string
   */
  public $quotaLimit;
  /**
   * @var string
   */
  public $quotaMinuteLimit;
  /**
   * @var string
   */
  public $quotaUsage;

  /**
   * @param MethodDetails[]
   */
  public function setMethodDetails($methodDetails)
  {
    $this->methodDetails = $methodDetails;
  }
  /**
   * @return MethodDetails[]
   */
  public function getMethodDetails()
  {
    return $this->methodDetails;
  }
  /**
   * @param string
   */
  public function setName($name)
  {
    $this->name = $name;
  }
  /**
   * @return string
   */
  public function getName()
  {
    return $this->name;
  }
  /**
   * @param string
   */
  public function setQuotaLimit($quotaLimit)
  {
    $this->quotaLimit = $quotaLimit;
  }
  /**
   * @return string
   */
  public function getQuotaLimit()
  {
    return $this->quotaLimit;
  }
  /**
   * @param string
   */
  public function setQuotaMinuteLimit($quotaMinuteLimit)
  {
    $this->quotaMinuteLimit = $quotaMinuteLimit;
  }
  /**
   * @return string
   */
  public function getQuotaMinuteLimit()
  {
    return $this->quotaMinuteLimit;
  }
  /**
   * @param string
   */
  public function setQuotaUsage($quotaUsage)
  {
    $this->quotaUsage = $quotaUsage;
  }
  /**
   * @return string
   */
  public function getQuotaUsage()
  {
    return $this->quotaUsage;
  }
}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(QuotaGroup::class, 'Google_Service_Css_QuotaGroup');
