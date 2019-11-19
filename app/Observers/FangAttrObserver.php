<?php

namespace App\Observers;

use App\Models\FangAttr;

class FangAttrObserver
{
    /**
     * Handle the fang attr "created" event.
     *
     * @param  \App\Models\FangAttr  $fangAttr
     * @return void
     */
    public function creating(FangAttr $fangAttr)
    {
//        dd(111);
        $field_name=request()->get('field_name');
//        dd($field_name);
        $fangAttr->field_name = $field_name == null ? '' : $field_name;
//        dd($fangAttr);
    }

    /**
     * Handle the fang attr "updated" event.
     *
     * @param  \App\Models\FangAttr  $fangAttr
     * @return void
     */
    public function updated(FangAttr $fangAttr)
    {
        //
    }

    /**
     * Handle the fang attr "deleted" event.
     *
     * @param  \App\Models\FangAttr  $fangAttr
     * @return void
     */
    public function deleted(FangAttr $fangAttr)
    {
        //
    }

    /**
     * Handle the fang attr "restored" event.
     *
     * @param  \App\Models\FangAttr  $fangAttr
     * @return void
     */
    public function restored(FangAttr $fangAttr)
    {
        //
    }

    /**
     * Handle the fang attr "force deleted" event.
     *
     * @param  \App\Models\FangAttr  $fangAttr
     * @return void
     */
    public function forceDeleted(FangAttr $fangAttr)
    {
        //
    }
}
