@php
    $targetArray = ["contact_display","whatsapp_display","image_gallery","video","location","map_display","city_leads","regional_leads","pan_india_leads","lead_form","micro_website","website_ad_banners"];
    $checkArray = $features;



    // Convert the arrays to Laravel collections
    $targetCollection = collect($targetArray);
    $checkCollection = collect($checkArray);

    // Get the items in $checkArray that are also in $targetArray
    $inArray = $checkCollection->intersect($targetCollection);

    // Get the items in $checkArray that are not in $targetArray
    $notInArray = $targetCollection->diff($checkCollection);


    // Convert to arrays if needed
    $inArray = $inArray->toArray();

    $notInArray = $notInArray->toArray();
     if(in_array('regional_leads',$inArray)){
        // Remove the value
        $notInArray = array_diff($notInArray, ['city_leads']);
        // Reindex the array
        $notInArray = array_values($notInArray);
    }
    if(in_array('pan_india_leads',$inArray)){
        // Remove the value
        $notInArray = array_diff($notInArray, ['city_leads']);
        $notInArray = array_diff($notInArray, ['regional_leads']);
        // Reindex the array
        $notInArray = array_values($notInArray);
    }




@endphp
@foreach($notInArray as $feature)
    <li><i class="bi bi-x text-danger"></i> <span>{{ ucwords(str_replace('_',' ',$feature)) }}</span></li>
@endforeach
