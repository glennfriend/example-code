import {Button, Form, Input, Checkbox, Spin} from 'antd';
import React, {useEffect, useState} from 'react';

interface IForm {
  usePhoneNumber: boolean;
  phoneNumbers?: string;
}

interface IProps {
  accountId: string;
}

/**
 * 建立 formValues 儲存所有的 form values
 * 優點是如果有很多值, 你不需要一個一個設定 useState
 * 而且相同的東西統一管理, 閱讀上較為方便
 */
export const MyComponent = (props: IProps) => {
  const {accountId} = props;
  const [form] = Form.useForm();
  const [formValues, setFormValues] = useState<IForm>();

  useEffect(() => {
    initData();
  }, []);

  const initData = async () => {
    if (form?.getFieldsValue()) {
      setFormValues(form.getFieldsValue());
    }
  }

  const onFinish = () => {
    const data: IForm = form.getFieldsValue();
    const {
      usePhoneNumber,
      phoneNumbers,
    } = data;
  }

  return (
    <Spin spinning={false} tip="Loading...">
      <Form
        name="my-form"
        form={form}
        labelCol={{span: 8}}
        wrapperCol={{span: 16}}
        initialValues={{}}
        onFinish={onFinish}
        onValuesChange={(changed, values) => {
          console.log({changed, values}); // for debug
          setFormValues(values);
        }}
      >

        <Form.Item name="hidden_id" initialValue="100" hidden>
          <Input/>
        </Form.Item>

        <Form.Item
          name="usePhoneNumber"
          label="Use Phone Number"
          valuePropName="checked"
          initialValue={false}
          rules={[{required: true, message: 'required !'}]}
        >
          <Checkbox>Enable</Checkbox>
        </Form.Item>

        <Form.Item
          name="phoneNumbers"
          label="Phone Number"
          extra="如果要使用 phone number, 請輸入號碼"
          hidden={!formValues?.usePhoneNumber}                              // 如果上面有勾, 就顯示, 否則穩藏
          rules={[
            {required: formValues?.usePhoneNumber, message: 'required !'}   // 如果上面有勾, 就是必填
          ]}   
        >
          <Input/>
        </Form.Item>

        <Form.Item wrapperCol={{offset: 8}}>
          <Button type="primary" htmlType="submit">
            Submit
          </Button>
        </Form.Item>
      </Form>
    </Spin>
  );
};

