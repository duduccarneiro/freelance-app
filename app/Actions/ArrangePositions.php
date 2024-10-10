<?php

namespace App\Actions;

use Illuminate\Support\Facades\DB;

class ArrangePositions
{
    public static function run(int $id)
    {
        DB::update('
                with ranked_proposals as (
                    SELECT id, ROW_NUMBER() OVER (ORDER BY hours) p
                    FROM proposals
                    WHERE project_id = :project
                )
                update proposals
                set position = (select p from ranked_proposals where proposals.id = ranked_proposals.id)
                WHERE project_id = :project2
            ', ['project' => $id,'project2' => $id]);
    }
}
