<?php

namespace PacificaSearchBundle\Repository;


use PacificaSearchBundle\Filter;
use PacificaSearchBundle\Service\ElasticSearchQueryBuilder;

class InstrumentRepository extends FilterRepository
{
    /**
     * @inheritdoc
     */
    public function getOwnIdsFromTransactionResults(array $transactionResults)
    {
        $ids = array_map(function ($result) {
            return $result['_source']['instrument'];
        }, $transactionResults);
        // TODO: Figure out how to make the original request unique instead of doing this here
        return array_values(array_unique($ids));
    }

    /**
     * @inheritdoc
     */
    protected function getType()
    {
        return ElasticSearchQueryBuilder::TYPE_INSTRUMENT;
    }

    /**
     * Gets the IDs of all instruments belonging to a set of instrument types
     * @param int[] $instrumentTypeIds
     * @return int[]
     */
    public function getIdsByType(array $instrumentTypeIds)
    {
        $qb = $this->getQueryBuilder()->whereIn('groups.group_id', $instrumentTypeIds);
        $results = $this->searchService->getIds($qb);

        return $results;
    }
}