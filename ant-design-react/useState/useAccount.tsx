import { useState } from 'react';
import { message } from 'antd';
import { tryCatch } from '@onr/shared';
import { AccountService, IAccount } from '@onr/account';

interface IFormValue extends IAccount {}

interface ILocalStorageSetting {
  accountId: number;
}

export const useAccount = () => {
  const [loading, setLoading] = useState(false);
  const [currentAccount, setCurrentAccount] = useState<IAccount>();

  const getAccountByLocalStorage = function() {
    const settingsString: string | null = localStorage.getItem('settings');
    if (!settingsString) {
      message.error('Get account id failed !');
      return;
    }
    const settings: ILocalStorageSetting = JSON.parse(settingsString);
    return settings.accountId;
  };

  const getCurrentAccount = tryCatch(async () => {
    const params = {
      accountId: getAccountByLocalStorage(),
    };
    const result = await AccountService.getAccount(params);
    if (!result.data) {
      message.error('Get account failed !');
      return;
    }
    const account = result.data;
    await setCurrentAccount(account);
  }, setLoading);

  const updateCurrentAccount = tryCatch(
    async (payload: { data: IFormValue; accountId?: number }) => {
      if (!payload.accountId) {
        message.error('Update account failed !');
        return;
      }
      await AccountService.updateAccount(payload);
      message.success('Update account succeeded !');

      await getCurrentAccount();
    },
    setLoading,
    () => {
      message.error('Update account failed.');
    },
  );

  return {
    loading,
    currentAccount,
    getCurrentAccount,
    updateCurrentAccount,
  };
};
