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

namespace Google\Service\DiscoveryEngine;

class GoogleCloudDiscoveryengineV1betaSearchRequest extends \Google\Collection
{
  protected $collection_key = 'facetSpecs';
  protected $boostSpecType = GoogleCloudDiscoveryengineV1betaSearchRequestBoostSpec::class;
  protected $boostSpecDataType = '';
  /**
   * @var string
   */
  public $branch;
  /**
   * @var string
   */
  public $canonicalFilter;
  protected $contentSearchSpecType = GoogleCloudDiscoveryengineV1betaSearchRequestContentSearchSpec::class;
  protected $contentSearchSpecDataType = '';
  protected $dataStoreSpecsType = GoogleCloudDiscoveryengineV1betaSearchRequestDataStoreSpec::class;
  protected $dataStoreSpecsDataType = 'array';
  protected $displaySpecType = GoogleCloudDiscoveryengineV1betaSearchRequestDisplaySpec::class;
  protected $displaySpecDataType = '';
  protected $embeddingSpecType = GoogleCloudDiscoveryengineV1betaSearchRequestEmbeddingSpec::class;
  protected $embeddingSpecDataType = '';
  protected $facetSpecsType = GoogleCloudDiscoveryengineV1betaSearchRequestFacetSpec::class;
  protected $facetSpecsDataType = 'array';
  /**
   * @var string
   */
  public $filter;
  protected $imageQueryType = GoogleCloudDiscoveryengineV1betaSearchRequestImageQuery::class;
  protected $imageQueryDataType = '';
  /**
   * @var string
   */
  public $languageCode;
  protected $naturalLanguageQueryUnderstandingSpecType = GoogleCloudDiscoveryengineV1betaSearchRequestNaturalLanguageQueryUnderstandingSpec::class;
  protected $naturalLanguageQueryUnderstandingSpecDataType = '';
  /**
   * @var int
   */
  public $offset;
  /**
   * @var int
   */
  public $oneBoxPageSize;
  /**
   * @var string
   */
  public $orderBy;
  /**
   * @var int
   */
  public $pageSize;
  /**
   * @var string
   */
  public $pageToken;
  /**
   * @var array[]
   */
  public $params;
  protected $personalizationSpecType = GoogleCloudDiscoveryengineV1betaSearchRequestPersonalizationSpec::class;
  protected $personalizationSpecDataType = '';
  /**
   * @var string
   */
  public $query;
  protected $queryExpansionSpecType = GoogleCloudDiscoveryengineV1betaSearchRequestQueryExpansionSpec::class;
  protected $queryExpansionSpecDataType = '';
  /**
   * @var string
   */
  public $rankingExpression;
  /**
   * @var string
   */
  public $rankingExpressionBackend;
  /**
   * @var string
   */
  public $regionCode;
  protected $relevanceScoreSpecType = GoogleCloudDiscoveryengineV1betaSearchRequestRelevanceScoreSpec::class;
  protected $relevanceScoreSpecDataType = '';
  /**
   * @var string
   */
  public $relevanceThreshold;
  /**
   * @var bool
   */
  public $safeSearch;
  protected $searchAsYouTypeSpecType = GoogleCloudDiscoveryengineV1betaSearchRequestSearchAsYouTypeSpec::class;
  protected $searchAsYouTypeSpecDataType = '';
  /**
   * @var string
   */
  public $servingConfig;
  /**
   * @var string
   */
  public $session;
  protected $sessionSpecType = GoogleCloudDiscoveryengineV1betaSearchRequestSessionSpec::class;
  protected $sessionSpecDataType = '';
  protected $spellCorrectionSpecType = GoogleCloudDiscoveryengineV1betaSearchRequestSpellCorrectionSpec::class;
  protected $spellCorrectionSpecDataType = '';
  protected $userInfoType = GoogleCloudDiscoveryengineV1betaUserInfo::class;
  protected $userInfoDataType = '';
  /**
   * @var string[]
   */
  public $userLabels;
  /**
   * @var string
   */
  public $userPseudoId;

  /**
   * @param GoogleCloudDiscoveryengineV1betaSearchRequestBoostSpec
   */
  public function setBoostSpec(GoogleCloudDiscoveryengineV1betaSearchRequestBoostSpec $boostSpec)
  {
    $this->boostSpec = $boostSpec;
  }
  /**
   * @return GoogleCloudDiscoveryengineV1betaSearchRequestBoostSpec
   */
  public function getBoostSpec()
  {
    return $this->boostSpec;
  }
  /**
   * @param string
   */
  public function setBranch($branch)
  {
    $this->branch = $branch;
  }
  /**
   * @return string
   */
  public function getBranch()
  {
    return $this->branch;
  }
  /**
   * @param string
   */
  public function setCanonicalFilter($canonicalFilter)
  {
    $this->canonicalFilter = $canonicalFilter;
  }
  /**
   * @return string
   */
  public function getCanonicalFilter()
  {
    return $this->canonicalFilter;
  }
  /**
   * @param GoogleCloudDiscoveryengineV1betaSearchRequestContentSearchSpec
   */
  public function setContentSearchSpec(GoogleCloudDiscoveryengineV1betaSearchRequestContentSearchSpec $contentSearchSpec)
  {
    $this->contentSearchSpec = $contentSearchSpec;
  }
  /**
   * @return GoogleCloudDiscoveryengineV1betaSearchRequestContentSearchSpec
   */
  public function getContentSearchSpec()
  {
    return $this->contentSearchSpec;
  }
  /**
   * @param GoogleCloudDiscoveryengineV1betaSearchRequestDataStoreSpec[]
   */
  public function setDataStoreSpecs($dataStoreSpecs)
  {
    $this->dataStoreSpecs = $dataStoreSpecs;
  }
  /**
   * @return GoogleCloudDiscoveryengineV1betaSearchRequestDataStoreSpec[]
   */
  public function getDataStoreSpecs()
  {
    return $this->dataStoreSpecs;
  }
  /**
   * @param GoogleCloudDiscoveryengineV1betaSearchRequestDisplaySpec
   */
  public function setDisplaySpec(GoogleCloudDiscoveryengineV1betaSearchRequestDisplaySpec $displaySpec)
  {
    $this->displaySpec = $displaySpec;
  }
  /**
   * @return GoogleCloudDiscoveryengineV1betaSearchRequestDisplaySpec
   */
  public function getDisplaySpec()
  {
    return $this->displaySpec;
  }
  /**
   * @param GoogleCloudDiscoveryengineV1betaSearchRequestEmbeddingSpec
   */
  public function setEmbeddingSpec(GoogleCloudDiscoveryengineV1betaSearchRequestEmbeddingSpec $embeddingSpec)
  {
    $this->embeddingSpec = $embeddingSpec;
  }
  /**
   * @return GoogleCloudDiscoveryengineV1betaSearchRequestEmbeddingSpec
   */
  public function getEmbeddingSpec()
  {
    return $this->embeddingSpec;
  }
  /**
   * @param GoogleCloudDiscoveryengineV1betaSearchRequestFacetSpec[]
   */
  public function setFacetSpecs($facetSpecs)
  {
    $this->facetSpecs = $facetSpecs;
  }
  /**
   * @return GoogleCloudDiscoveryengineV1betaSearchRequestFacetSpec[]
   */
  public function getFacetSpecs()
  {
    return $this->facetSpecs;
  }
  /**
   * @param string
   */
  public function setFilter($filter)
  {
    $this->filter = $filter;
  }
  /**
   * @return string
   */
  public function getFilter()
  {
    return $this->filter;
  }
  /**
   * @param GoogleCloudDiscoveryengineV1betaSearchRequestImageQuery
   */
  public function setImageQuery(GoogleCloudDiscoveryengineV1betaSearchRequestImageQuery $imageQuery)
  {
    $this->imageQuery = $imageQuery;
  }
  /**
   * @return GoogleCloudDiscoveryengineV1betaSearchRequestImageQuery
   */
  public function getImageQuery()
  {
    return $this->imageQuery;
  }
  /**
   * @param string
   */
  public function setLanguageCode($languageCode)
  {
    $this->languageCode = $languageCode;
  }
  /**
   * @return string
   */
  public function getLanguageCode()
  {
    return $this->languageCode;
  }
  /**
   * @param GoogleCloudDiscoveryengineV1betaSearchRequestNaturalLanguageQueryUnderstandingSpec
   */
  public function setNaturalLanguageQueryUnderstandingSpec(GoogleCloudDiscoveryengineV1betaSearchRequestNaturalLanguageQueryUnderstandingSpec $naturalLanguageQueryUnderstandingSpec)
  {
    $this->naturalLanguageQueryUnderstandingSpec = $naturalLanguageQueryUnderstandingSpec;
  }
  /**
   * @return GoogleCloudDiscoveryengineV1betaSearchRequestNaturalLanguageQueryUnderstandingSpec
   */
  public function getNaturalLanguageQueryUnderstandingSpec()
  {
    return $this->naturalLanguageQueryUnderstandingSpec;
  }
  /**
   * @param int
   */
  public function setOffset($offset)
  {
    $this->offset = $offset;
  }
  /**
   * @return int
   */
  public function getOffset()
  {
    return $this->offset;
  }
  /**
   * @param int
   */
  public function setOneBoxPageSize($oneBoxPageSize)
  {
    $this->oneBoxPageSize = $oneBoxPageSize;
  }
  /**
   * @return int
   */
  public function getOneBoxPageSize()
  {
    return $this->oneBoxPageSize;
  }
  /**
   * @param string
   */
  public function setOrderBy($orderBy)
  {
    $this->orderBy = $orderBy;
  }
  /**
   * @return string
   */
  public function getOrderBy()
  {
    return $this->orderBy;
  }
  /**
   * @param int
   */
  public function setPageSize($pageSize)
  {
    $this->pageSize = $pageSize;
  }
  /**
   * @return int
   */
  public function getPageSize()
  {
    return $this->pageSize;
  }
  /**
   * @param string
   */
  public function setPageToken($pageToken)
  {
    $this->pageToken = $pageToken;
  }
  /**
   * @return string
   */
  public function getPageToken()
  {
    return $this->pageToken;
  }
  /**
   * @param array[]
   */
  public function setParams($params)
  {
    $this->params = $params;
  }
  /**
   * @return array[]
   */
  public function getParams()
  {
    return $this->params;
  }
  /**
   * @param GoogleCloudDiscoveryengineV1betaSearchRequestPersonalizationSpec
   */
  public function setPersonalizationSpec(GoogleCloudDiscoveryengineV1betaSearchRequestPersonalizationSpec $personalizationSpec)
  {
    $this->personalizationSpec = $personalizationSpec;
  }
  /**
   * @return GoogleCloudDiscoveryengineV1betaSearchRequestPersonalizationSpec
   */
  public function getPersonalizationSpec()
  {
    return $this->personalizationSpec;
  }
  /**
   * @param string
   */
  public function setQuery($query)
  {
    $this->query = $query;
  }
  /**
   * @return string
   */
  public function getQuery()
  {
    return $this->query;
  }
  /**
   * @param GoogleCloudDiscoveryengineV1betaSearchRequestQueryExpansionSpec
   */
  public function setQueryExpansionSpec(GoogleCloudDiscoveryengineV1betaSearchRequestQueryExpansionSpec $queryExpansionSpec)
  {
    $this->queryExpansionSpec = $queryExpansionSpec;
  }
  /**
   * @return GoogleCloudDiscoveryengineV1betaSearchRequestQueryExpansionSpec
   */
  public function getQueryExpansionSpec()
  {
    return $this->queryExpansionSpec;
  }
  /**
   * @param string
   */
  public function setRankingExpression($rankingExpression)
  {
    $this->rankingExpression = $rankingExpression;
  }
  /**
   * @return string
   */
  public function getRankingExpression()
  {
    return $this->rankingExpression;
  }
  /**
   * @param string
   */
  public function setRankingExpressionBackend($rankingExpressionBackend)
  {
    $this->rankingExpressionBackend = $rankingExpressionBackend;
  }
  /**
   * @return string
   */
  public function getRankingExpressionBackend()
  {
    return $this->rankingExpressionBackend;
  }
  /**
   * @param string
   */
  public function setRegionCode($regionCode)
  {
    $this->regionCode = $regionCode;
  }
  /**
   * @return string
   */
  public function getRegionCode()
  {
    return $this->regionCode;
  }
  /**
   * @param GoogleCloudDiscoveryengineV1betaSearchRequestRelevanceScoreSpec
   */
  public function setRelevanceScoreSpec(GoogleCloudDiscoveryengineV1betaSearchRequestRelevanceScoreSpec $relevanceScoreSpec)
  {
    $this->relevanceScoreSpec = $relevanceScoreSpec;
  }
  /**
   * @return GoogleCloudDiscoveryengineV1betaSearchRequestRelevanceScoreSpec
   */
  public function getRelevanceScoreSpec()
  {
    return $this->relevanceScoreSpec;
  }
  /**
   * @param string
   */
  public function setRelevanceThreshold($relevanceThreshold)
  {
    $this->relevanceThreshold = $relevanceThreshold;
  }
  /**
   * @return string
   */
  public function getRelevanceThreshold()
  {
    return $this->relevanceThreshold;
  }
  /**
   * @param bool
   */
  public function setSafeSearch($safeSearch)
  {
    $this->safeSearch = $safeSearch;
  }
  /**
   * @return bool
   */
  public function getSafeSearch()
  {
    return $this->safeSearch;
  }
  /**
   * @param GoogleCloudDiscoveryengineV1betaSearchRequestSearchAsYouTypeSpec
   */
  public function setSearchAsYouTypeSpec(GoogleCloudDiscoveryengineV1betaSearchRequestSearchAsYouTypeSpec $searchAsYouTypeSpec)
  {
    $this->searchAsYouTypeSpec = $searchAsYouTypeSpec;
  }
  /**
   * @return GoogleCloudDiscoveryengineV1betaSearchRequestSearchAsYouTypeSpec
   */
  public function getSearchAsYouTypeSpec()
  {
    return $this->searchAsYouTypeSpec;
  }
  /**
   * @param string
   */
  public function setServingConfig($servingConfig)
  {
    $this->servingConfig = $servingConfig;
  }
  /**
   * @return string
   */
  public function getServingConfig()
  {
    return $this->servingConfig;
  }
  /**
   * @param string
   */
  public function setSession($session)
  {
    $this->session = $session;
  }
  /**
   * @return string
   */
  public function getSession()
  {
    return $this->session;
  }
  /**
   * @param GoogleCloudDiscoveryengineV1betaSearchRequestSessionSpec
   */
  public function setSessionSpec(GoogleCloudDiscoveryengineV1betaSearchRequestSessionSpec $sessionSpec)
  {
    $this->sessionSpec = $sessionSpec;
  }
  /**
   * @return GoogleCloudDiscoveryengineV1betaSearchRequestSessionSpec
   */
  public function getSessionSpec()
  {
    return $this->sessionSpec;
  }
  /**
   * @param GoogleCloudDiscoveryengineV1betaSearchRequestSpellCorrectionSpec
   */
  public function setSpellCorrectionSpec(GoogleCloudDiscoveryengineV1betaSearchRequestSpellCorrectionSpec $spellCorrectionSpec)
  {
    $this->spellCorrectionSpec = $spellCorrectionSpec;
  }
  /**
   * @return GoogleCloudDiscoveryengineV1betaSearchRequestSpellCorrectionSpec
   */
  public function getSpellCorrectionSpec()
  {
    return $this->spellCorrectionSpec;
  }
  /**
   * @param GoogleCloudDiscoveryengineV1betaUserInfo
   */
  public function setUserInfo(GoogleCloudDiscoveryengineV1betaUserInfo $userInfo)
  {
    $this->userInfo = $userInfo;
  }
  /**
   * @return GoogleCloudDiscoveryengineV1betaUserInfo
   */
  public function getUserInfo()
  {
    return $this->userInfo;
  }
  /**
   * @param string[]
   */
  public function setUserLabels($userLabels)
  {
    $this->userLabels = $userLabels;
  }
  /**
   * @return string[]
   */
  public function getUserLabels()
  {
    return $this->userLabels;
  }
  /**
   * @param string
   */
  public function setUserPseudoId($userPseudoId)
  {
    $this->userPseudoId = $userPseudoId;
  }
  /**
   * @return string
   */
  public function getUserPseudoId()
  {
    return $this->userPseudoId;
  }
}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(GoogleCloudDiscoveryengineV1betaSearchRequest::class, 'Google_Service_DiscoveryEngine_GoogleCloudDiscoveryengineV1betaSearchRequest');
