import React from 'react';
import { Form, Select } from 'antd';
import { FormInstance } from "antd/lib/form";
import { DefaultOptionType } from 'rc-select/lib/Select';

interface IFormSectionProps {
    form: FormInstance;
}

// filter 是只留下條件成立的
const userOptions: DefaultOptionType[] = allUsers
    ?.filter(item => item.id !== user.id)
    ?.filter(item => item.status === 'enabled' || item.status === 'disabled')
    .map((item: { id: number; name: string }) => ({
        value: item.id,
        label: `${item.name} (${item.id})`,
}));


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
                return       customOption?.label.toLowerCase().indexOf(input.toLowerCase()) >= 0;     // 在 label 中搜尋
                // return `${customOption?.key}`.toLowerCase().includes(input.toLowerCase());
            }}
            options={userOptions}
            loading={false}
            // value={selectedTrigger}  // Form.Item 不能用 value, value 是給 useState 使用的
        />
    </Form.Item>
};

return (
    <div>
        {getFieldDecorator('user.blogs', {
            initialValue: [],
        })(
            <Select mode="multiple" />,
        )}
    </div>
);