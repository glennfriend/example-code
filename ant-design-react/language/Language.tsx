import {Tooltip} from "antd";
import React from "react";
import {TooltipPlacement} from "antd/lib/tooltip";
import {InfoCircleOutlined} from "@ant-design/icons";

export declare type DescriptionLanguageScope =
  'name'
  | 'age'
  | 'userPhoneNumber';

interface IConfig {
  [key: string]: {
    title: string;
    position: TooltipPlacement;
    description: string;
  }
}

interface IProps {
  type: DescriptionLanguageScope;
}

/**
 * labels tip language
 *    - support Tooltip
 *    - support icon
 *
 *  <Form.Item name="name" label={<DescriptionLanguage type="name" />}>
 *      <Input />
 *  </Form.Item>
 */
export const DescriptionLanguage = function (props: IProps) {
  const {type} = props;
  const config: IConfig = {
    name: {
      title: 'Name',
      position: 'bottom',
      description: '請填上姓名',
    },
    age: {
      title: 'Age',
      position: 'bottom',
      description: '年齡必須 18 歲以上',
    },
    userPhoneNumber: {
      title: 'User Phone Number',
      position: 'bottom',
      description:
        'require:' + '\n' +
        '    - 市話必須有縣市開頭 例如 02' + '\n' +
        '    - 手機為 10 碼 例如 0922555666' + '\n' +
        'other:' + '\n' +
        '    - other' + '\n',
    },
  };

  const {title, position, description} = config[type];
  return (
    <Tooltip
      placement={position}
      title={description}
      overlayStyle={{whiteSpace: 'pre-line', minWidth: 400}}
    >
      <span>{title} <InfoCircleOutlined/></span>
    </Tooltip>
  );

}
