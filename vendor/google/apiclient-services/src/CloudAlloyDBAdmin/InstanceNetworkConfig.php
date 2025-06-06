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

namespace Google\Service\CloudAlloyDBAdmin;

class InstanceNetworkConfig extends \Google\Collection
{
  protected $collection_key = 'authorizedExternalNetworks';
  /**
   * @var string
   */
  public $allocatedIpRangeOverride;
  protected $authorizedExternalNetworksType = AuthorizedNetwork::class;
  protected $authorizedExternalNetworksDataType = 'array';
  /**
   * @var bool
   */
  public $enableOutboundPublicIp;
  /**
   * @var bool
   */
  public $enablePublicIp;
  /**
   * @var string
   */
  public $network;

  /**
   * @param string
   */
  public function setAllocatedIpRangeOverride($allocatedIpRangeOverride)
  {
    $this->allocatedIpRangeOverride = $allocatedIpRangeOverride;
  }
  /**
   * @return string
   */
  public function getAllocatedIpRangeOverride()
  {
    return $this->allocatedIpRangeOverride;
  }
  /**
   * @param AuthorizedNetwork[]
   */
  public function setAuthorizedExternalNetworks($authorizedExternalNetworks)
  {
    $this->authorizedExternalNetworks = $authorizedExternalNetworks;
  }
  /**
   * @return AuthorizedNetwork[]
   */
  public function getAuthorizedExternalNetworks()
  {
    return $this->authorizedExternalNetworks;
  }
  /**
   * @param bool
   */
  public function setEnableOutboundPublicIp($enableOutboundPublicIp)
  {
    $this->enableOutboundPublicIp = $enableOutboundPublicIp;
  }
  /**
   * @return bool
   */
  public function getEnableOutboundPublicIp()
  {
    return $this->enableOutboundPublicIp;
  }
  /**
   * @param bool
   */
  public function setEnablePublicIp($enablePublicIp)
  {
    $this->enablePublicIp = $enablePublicIp;
  }
  /**
   * @return bool
   */
  public function getEnablePublicIp()
  {
    return $this->enablePublicIp;
  }
  /**
   * @param string
   */
  public function setNetwork($network)
  {
    $this->network = $network;
  }
  /**
   * @return string
   */
  public function getNetwork()
  {
    return $this->network;
  }
}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(InstanceNetworkConfig::class, 'Google_Service_CloudAlloyDBAdmin_InstanceNetworkConfig');
