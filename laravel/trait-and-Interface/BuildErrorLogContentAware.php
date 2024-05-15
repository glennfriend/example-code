<?php

namespace Modules\Core\Concerns;

use Modules\Account\Entities\Account;
use Modules\AppIntegration\Entities\AppIntegration;
use Modules\Contact\Entities\Contact;

/**
 * Modules/Core/Concerns/BuildErrorLogContentAware.php
 * 
 * Eddie: Core 不應該知道 Contact, Account, AppIntegration .... 這個是錯誤的寫法, 而且現在還不需要做這件事
 */
trait BuildErrorLogContentAware
{
    protected function buildErrorLogContent(array $objects): array
    {
        $content = [];
        foreach ($objects as $instance) {
            match (true) {
                $instance instanceof Contact => $this->buildContactContent($instance, $content),
                $instance instanceof Account => $this->buildAccountContent($instance, $content),
                $instance instanceof AppIntegration => $this->buildAppIntegrationContent($instance, $content),
            };
        }

        return $content;
    }

    private function buildContactContent(Contact $contact, array &$content): void
    {
        $content['contact_id'] = $contact->id;
    }

    private function buildAccountContent(Account $account, array &$content): void
    {
        $content['account_id'] = $account->id;
        $content['account_name'] = $account->name;
    }

    private function buildAppIntegrationContent(AppIntegration $appIntegration, array &$content): void
    {
        $content['app_integration_id'] = $appIntegration->id;
        $content['app_integration_name'] = $appIntegration->name;
        $content['app_integration_type'] = $appIntegration->type;
    }
}
