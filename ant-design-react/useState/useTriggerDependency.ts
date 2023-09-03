import { useState } from 'react';
import { message } from 'antd';
import { tryCatch } from '@onr/shared';
import { TriggerDependency } from '@onr/trigger';

export const useTriggerDependency = () => {
  const [loading, setLoading] = useState(false);
  const [triggerDependencies, setTriggerDependencies] = useState<TriggerDependency>();

  const getAllByTriggerId = tryCatch(async (triggerId: number) => {
    if (!triggerId) {
      message.error('TriggerDependency not found');
      return;
    }
    /*
    const params = {
      triggerId: triggerId,
      params: {},
    };
    const result = await TriggerDependencyService.getTriggers(params);
    if (!result.data) {
      message.error('Get TriggerDependency failed !');
      return;
    }
    const target = result.data;
    */
    const target: TriggerDependency = [
      {
        trigger_id: triggerId,
        dependent_trigger_id: 101,
      },
      {
        trigger_id: triggerId,
        dependent_trigger_id: 102,
      },
    ];

    setTriggerDependencies(target);
  }, setLoading);

  return {
    loading,
    triggerDependencies,
    getAllByTriggerId,
  };
};
