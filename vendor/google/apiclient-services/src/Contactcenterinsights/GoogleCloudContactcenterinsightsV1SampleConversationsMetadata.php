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

namespace Google\Service\Contactcenterinsights;

class GoogleCloudContactcenterinsightsV1SampleConversationsMetadata extends \Google\Collection
{
  protected $collection_key = 'partialErrors';
  /**
   * @var string
   */
  public $createTime;
  /**
   * @var string
   */
  public $endTime;
  protected $partialErrorsType = GoogleRpcStatus::class;
  protected $partialErrorsDataType = 'array';
  protected $requestType = GoogleCloudContactcenterinsightsV1SampleConversationsRequest::class;
  protected $requestDataType = '';
  protected $sampleConversationsStatsType = GoogleCloudContactcenterinsightsV1SampleConversationsMetadataSampleConversationsStats::class;
  protected $sampleConversationsStatsDataType = '';

  /**
   * @param string
   */
  public function setCreateTime($createTime)
  {
    $this->createTime = $createTime;
  }
  /**
   * @return string
   */
  public function getCreateTime()
  {
    return $this->createTime;
  }
  /**
   * @param string
   */
  public function setEndTime($endTime)
  {
    $this->endTime = $endTime;
  }
  /**
   * @return string
   */
  public function getEndTime()
  {
    return $this->endTime;
  }
  /**
   * @param GoogleRpcStatus[]
   */
  public function setPartialErrors($partialErrors)
  {
    $this->partialErrors = $partialErrors;
  }
  /**
   * @return GoogleRpcStatus[]
   */
  public function getPartialErrors()
  {
    return $this->partialErrors;
  }
  /**
   * @param GoogleCloudContactcenterinsightsV1SampleConversationsRequest
   */
  public function setRequest(GoogleCloudContactcenterinsightsV1SampleConversationsRequest $request)
  {
    $this->request = $request;
  }
  /**
   * @return GoogleCloudContactcenterinsightsV1SampleConversationsRequest
   */
  public function getRequest()
  {
    return $this->request;
  }
  /**
   * @param GoogleCloudContactcenterinsightsV1SampleConversationsMetadataSampleConversationsStats
   */
  public function setSampleConversationsStats(GoogleCloudContactcenterinsightsV1SampleConversationsMetadataSampleConversationsStats $sampleConversationsStats)
  {
    $this->sampleConversationsStats = $sampleConversationsStats;
  }
  /**
   * @return GoogleCloudContactcenterinsightsV1SampleConversationsMetadataSampleConversationsStats
   */
  public function getSampleConversationsStats()
  {
    return $this->sampleConversationsStats;
  }
}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(GoogleCloudContactcenterinsightsV1SampleConversationsMetadata::class, 'Google_Service_Contactcenterinsights_GoogleCloudContactcenterinsightsV1SampleConversationsMetadata');
