import { useState } from 'react';
import { message } from 'antd';
import { tryCatch } from '@onr/shared';
import { ITrigger } from '@onr/trigger';
import { TriggerService } from '@onr/trigger';

export const useTrigger = () => {
  const [loading, setLoading] = useState(false);
  const [enabledTriggers, setEnabledTriggers] = useState<ITrigger>();

  const getEnabledTriggers = tryCatch(async (accountId: number) => {
    if (!accountId) {
      console.log('account not found');
      return;
    }
    const params = {
      accountId: accountId,
      params: {},
    };
    const result = await TriggerService.getTriggers(params);
    if (!result.data) {
      message.error('Get trigger failed !');
      return;
    }
    const allTriggers = result.data;
    const enabledTriggers = allTriggers.filter((trigger: { enabled: boolean }) => trigger.enabled);

    setEnabledTriggers(enabledTriggers);
  }, setLoading);

  return {
    loading,
    enabledTriggers,
    getEnabledTriggers,
  };
};
