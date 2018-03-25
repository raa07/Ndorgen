<?php

namespace Tools\DuplicatesValidators\Validators;

use App\GlobalModels\Links;
use Tools\DuplicatesValidators\DuplicatesValidator;
use Tools\DuplicatesValidators\DuplicatesValidatorInterface;

final class CommentsDuplicatesValidator extends DuplicatesValidator implements DuplicatesValidatorInterface
{
    public function validate($links)
    {
        $links_model = new Links(Links::$COMMENT_PREFIX);
        $validate_links = $links_model->checkLink($links);
        if(!empty($validate_links)) {
            $links_model->addLinks($validate_links);
        }

        return $validate_links;
    }
}