<?php
function setRelationshipData($type, $data)
{
    $return = [];
    if (!$data) return;
    if (isset($data['id'])) {
        return $return[] = [
            'id' =>  $data['id'],
            'type' => $type
        ];
    } else {


        foreach ($data as  $value) {


            $return[] = [
                'id' => $value->id,
                'type' => $type
            ];
        }
    }

    return $return;
}
