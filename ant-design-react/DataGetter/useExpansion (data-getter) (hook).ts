import {useState} from 'react';
import {message} from "antd";
import {xxxxAPIService} from "../../campaign";

/**
 * data getter by custom hook
 *
 * e.g.

  import {useExpansion} from "../hooks";


  export const ExpansionCommon = () => {

    const {users, getUsers, blogs, getBlogs} = useUserDataGetter();

    useEffect(() => {
      initData();
    }, []);

    const initData = async () => {
      tryCatch(async () => {
        getUsers(100);
        getBlogs();
      }, () => {
        message.error('Failed to initialization');
      }, setLoading);
    };

  };
 *
 */
export const useExpansion = () => {
  const [loading, setLoading] = useState(false);
  const [users, setUsers] = useState<object[]>([]);
  const [blogs, setBlogs] = useState<object[]>([]);


  const getUsers = async (accountId: string) => {
    return tryCatch(async () => {
      const result = await xxxxAPIService.getUsers({accountId});
      if (!result.data) {
        message.error('Get xxxx failed !');
        return;
      }

      const selectOptions = result?.data?.map(x => ({
        label: x.campaignName,
        value: x.campaignId,
      }));
      setUsers(selectOptions);
    }, setLoading)();
  };

  const getBlogs = async () => {
    return tryCatch(async () => {
      const result = await xxxxAPIService.getBlogs();
      if (!result.data) {
        message.error('Get xxxx failed !');
        return;
      }

      const selectOptions = result?.data
        .filter(function (item: any) {
          return item.name.substr(0, 4) !== 'test';
        }).map(({name, id}) => ({
          label: `${name} (id: ${id})`,
          value: id,
        }))
        .sort((a, z) => z.label.localeCompare(a.label))
      ;

      setBlogs(selectOptions);
    }, setLoading)();
  };

  return {
    loading,
    users, getUsers,
    blogs, getBlogs,
  };
};




// private
import { optFailure } from '@onr/shared';
/*
export const optSuccess = (msg?: string) => {
  message.success(msg || 'Operation Successfully Completed!');
};
export const optFailure = (msg?: string) => {
  message.error(msg || `Something went wrong. Please refresh or contact the admin.`, 10);
};
*/

export const tryCatch = <T extends any[], U>(
  tryFtn: (...p: T) => Promise<U>,
  setLoading?: (state: boolean) => void,
  catchFtn?: (e?: Error) => void
) => async (...p: T) => {
  try {
    typeof setLoading === 'function' && setLoading(true);
    return await tryFtn(...p);
  } catch (e) {
    if (typeof catchFtn === 'function') {
      catchFtn(e);
      throw e;
    } else {
      console.error(e);
      optFailure();
      throw e;
    }
  } finally {
    typeof setLoading === 'function' && setLoading(false);
  }
};




// laura 推薦的 example 
//    https://github.com/OnrampLab/ava-client/blob/develop/src/modules/ivr/settings/hooks/use-ivr-settings.ts
//    https://github.com/OnrampLab/ava-client/blob/develop/src/app/hooks/usePermission.tsx


