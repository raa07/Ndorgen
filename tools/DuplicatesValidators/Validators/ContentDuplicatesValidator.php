<?php

namespace Tools\DuplicatesValidators\Validators;

use App\GlobalModels\Links;
use Tools\DuplicatesValidators\DuplicatesValidator;
use Tools\DuplicatesValidators\DuplicatesValidatorInterface;

final class ContentDuplicatesValidator extends DuplicatesValidator implements DuplicatesValidatorInterface
{
    public function validate($links_data)
    {
        $result = [];
        $links = array_keys($links_data);
        $links_model = new Links(Links::$CONTENT_PREFIX);
        $validate_links = $links_model->checkLink($links);

        foreach($validate_links as $link) {
            $result[] = $links_data[$link];
        }
        if(!empty($validate_links)) {
            $links_model->addLinks($validate_links);
        }

        return $result;
    }
}