//#region Local Imports
import { Http } from '@onr/core';
import { logCatch } from '@onr/shared';
//#endregion Local Imports

export interface IGetAccounts {
    data: IGetAccount[];
}

export interface IGetAccount {
    id: number;
    name: string;
    account_id: string;
}

export const SkynetService = {
    /**
     * /api/skynet/accounts
     */
    getAccounts: async (): Promise<any> => {
        try {
            return await SkynetService.test();   // TODO: remove it
            return await Http.get<any>(`/skynet/accounts`);
        } catch (error) {
            throw logCatch('', 'SkynetService', 'getAccounts', error.message);
        }
    },

    test: async (): Promise<any> => {
        const data = `
{
    "data": [
        {
            "id": 12,
            "name": "Account 12",
            "account_id": "7472174444"
        },
        {
            "id": 74,
            "name": "Account 74",
            "account_id": "6760284444"
        }
    ]
}
`;
        return JSON.parse(data);
    },
};
