import React from 'react';
import {Form, Select} from 'antd';
import {FormInstance} from "antd/lib/form";

interface IFormSectionProps {
    form: FormInstance;
}

export const HelloFormSection: React.FC<IFormSectionProps> = () => {

    <Form.Item
        label="Account ID"
        name={['appIntegration', 'config', 'account_id']}
        rules={[{required: true, message: 'Please input Account ID!'}]}
        initialValue={null}
        hasFeedback
    >
        <Select
            // search, 下拉式選項
            showSearch
            filterOption={(input, option) => {
                const customOption = option as any;
                return customOption?.label.toLowerCase().indexOf(input.toLowerCase()) >= 0;     // 在 label 中搜尋
            }}
            options={null}
            loading={false}
        />
    </Form.Item>

};