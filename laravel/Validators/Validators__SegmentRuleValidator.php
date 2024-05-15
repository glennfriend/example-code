<?php

namespace Modules\Segment\Validators;

use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Modules\Segment\ValueObjects\RuleValue;
use Modules\Segment\ValueObjects\SegmentImportResource;

/**
 * e.g.
 *      SegmentRuleValidator::validate($this);
 */
class SegmentRuleValidator
{
    /**
     * @throws Exception
     */
    public static function validate(SegmentImportResource $resource): void
    {
        if (!$resource->ruleCondition
            && !$resource->ruleFieldType
            && !$resource->ruleFieldName
            && !$resource->ruleOperator
            && !$resource->ruleValue) {
            return;
        }
        if (!$resource->ruleCondition
            || !$resource->ruleFieldType
            || !$resource->ruleFieldName
            || !$resource->ruleOperator
            || !$resource->ruleValue) {
            throw new Exception('`rule` are missing');
        }

        $validator = Validator::make([
            'rule_condition' => $resource->ruleCondition,
            'rule_field_type' => $resource->ruleFieldType,
            'rule_field_name' => $resource->ruleFieldName,
            'rule_operator' => $resource->ruleOperator,
            'rule_value' => $resource->ruleValue,
        ], [
            'rule_condition' => ['nullable', Rule::in(['must include', 'must exclude', 'or include'])],
            'rule_field_type' => 'nullable|string',
            'rule_field_name' => 'nullable|string',
            'rule_operator' => 'nullable|string',
            'rule_value' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            $param = key($validator->failed());
            throw new Exception('Rule condition failed: ' . $param);
        }

        RuleValue::create($resource->ruleOperator, $resource->ruleValue);
    }
}


