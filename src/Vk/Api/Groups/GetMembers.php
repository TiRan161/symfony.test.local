<?php


namespace App\Vk\Api\Groups;


use App\Vk\Api\AbstractMethod;

class GetMembers extends AbstractMethod
{
    protected $url = '/method/groups.getMembers';

    /** @var string */
    private $groupId;
    /** @var string */
    private $sort;
    /** @var integer */
    private $offset;
    /** @var integer */
    private $count;
    /** @var string */
    private $fields;
    /** @var string */
    private $filter;

    /**
     * @inheritDoc
     */
    public function getParams()
    {
        $params = [
            'group_id' => $this->groupId
        ];
        if (null !== $this->sort) {
            $params['sort'] = $this->sort;
        }
        if (null !== $this->offset) {
            $params['offset'] = $this->offset;
        }
        if (null !== $this->count) {
            $params['count'] = $this->count;
        }
        if (null !== $this->fields) {
            $params['fields'] = $this->fields;
        }
        if (null !== $this->filter) {
            $params['filter'] = $this->filter;
        }
        return $params;
    }

    /**
     * @param string $groupId
     */
    public function setGroupId(string $groupId): void
    {
        $this->groupId = $groupId;
    }

    /**
     * @param string $sort
     */
    public function setSort(string $sort): void
    {
        $this->sort = $sort;
    }

    /**
     * @param int $offset
     */
    public function setOffset(int $offset): void
    {
        $this->offset = $offset;
    }

    /**
     * @param int $count
     */
    public function setCount(int $count): void
    {
        $this->count = $count;
    }

    /**
     * @param string $fields
     */
    public function setFields(string $fields): void
    {
        $this->fields = $fields;
    }

    /**
     * @param string $filter
     */
    public function setFilter(string $filter): void
    {
        $this->filter = $filter;
    }


}