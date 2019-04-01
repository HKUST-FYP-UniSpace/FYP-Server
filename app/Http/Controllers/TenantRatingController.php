<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use TenantRating;

class TenantRatingController extends Controller
{
  public function list_all_tenant_ratings() {
     $tenant_ratings = array();
     $stacks = TenantRating::get();
     foreach($stacks as $stack) {
         $tenant_rating = array();
         $tenant_rating['id'] = $stack->id;
         $tenant_rating['tenant_id'] = $stack->tenant_id;
         $tenant_rating['owner_id'] = $stack->owner_id;
         $tenant_rating['rate'] = $stack->rate;
         $tenant_rating['review'] = $stack->review;
         $tenant_rating['created_at'] = $stack->created_at;
     }
     return $tenant_ratings;
   }
}
