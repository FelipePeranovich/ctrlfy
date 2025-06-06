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

namespace Google\Service\DisplayVideo;

class AlgorithmRulesSignal extends \Google\Model
{
  /**
   * @var string
   */
  public $activeViewSignal;
  /**
   * @var string
   */
  public $clickSignal;
  /**
   * @var string
   */
  public $impressionSignal;

  /**
   * @param string
   */
  public function setActiveViewSignal($activeViewSignal)
  {
    $this->activeViewSignal = $activeViewSignal;
  }
  /**
   * @return string
   */
  public function getActiveViewSignal()
  {
    return $this->activeViewSignal;
  }
  /**
   * @param string
   */
  public function setClickSignal($clickSignal)
  {
    $this->clickSignal = $clickSignal;
  }
  /**
   * @return string
   */
  public function getClickSignal()
  {
    return $this->clickSignal;
  }
  /**
   * @param string
   */
  public function setImpressionSignal($impressionSignal)
  {
    $this->impressionSignal = $impressionSignal;
  }
  /**
   * @return string
   */
  public function getImpressionSignal()
  {
    return $this->impressionSignal;
  }
}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(AlgorithmRulesSignal::class, 'Google_Service_DisplayVideo_AlgorithmRulesSignal');
