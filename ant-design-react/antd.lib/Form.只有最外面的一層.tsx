import React, { useEffect } from 'react';
import { message, Button, Card, Form, Input, Spin } from 'antd';
import { AccountService, IAccount, useAccount} from '@onr/account';
import { pick } from 'lodash';

interface IFormValue extends IAccount {
}

const getDefaultFormData = (account?: IAccount | null) => {
  if (!account) return {} as Partial<IFormValue>;

  const form: Partial<IFormValue> = {
    ...account,
  };

  return pick(form, ['name', 'id', 'operation_setting']);
};

export const MainPage: React.FC = () => {
  const [form] = Form.useForm();
  const { loading, currentAccount, getCurrentAccount } = useAccount();

  useEffect(() => {
    getCurrentAccount();
  }, []);

  useEffect(() => {
    if (currentAccount) {
      form.setFieldsValue(getDefaultFormData(currentAccount));
    }
  }, [currentAccount]);

  const onFinish = async () => {
    try {
      const formValues: IFormValue = await form.validateFields();
      const payload = {
        data: formValues,
        accountId: currentAccount?.id,
      };

      console.log(payload);
      //AccountService.updateAccount(payload);
      //message.success('Account Update Succeeded!');
    } catch (error) {
      if (error?.errorFields?.[0]?.name) {
        form.scrollToField(error?.errorFields?.[0]?.name);
      } else {
        message.error('Account Update Failed.');
      }
    }
  };

  return (
    <Form
      form={form}
      name="basic"
      labelCol={{ span: 8 }}
      wrapperCol={{ span: 16 }}
      initialValues={{ remember: true }}
      onFinish={onFinish}
      autoComplete="off"
    >
      <Form.Item
        label="name"
        name="name"
        rules={[{ required: true, message: 'Please input your username!' }]}
      >
        <Input />
      </Form.Item>

      <Form.Item wrapperCol={{ offset: 8, span: 16 }}>
        <Button type="primary" htmlType="submit">
          Submit
        </Button>
      </Form.Item>
    </Form>
  );
};
