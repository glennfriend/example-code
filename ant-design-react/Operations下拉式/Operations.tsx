import React from 'react';
import {Dropdown, Menu, Popconfirm} from 'antd';
import {DownOutlined, EditOutlined} from '@ant-design/icons';
import Link from 'next/link';
import {Contact} from '@onr/contact';

export const ContactSearchList: React.FC<any> = ({}) => {

  const columns = getColumns();

  function getColumns() {
    const columns = [
      {
        title: 'Id',
        dataIndex: 'id',
      },
      {
        title: 'Email',
        dataIndex: 'email',
      },
      {
        title: 'Operations',
        dataIndex: 'operations',
        key: 'id2',
        // eslint-disable-next-line react/display-name
        render: (_: string, contact: Contact) => {
          const menu = (
              <Menu>
                <Menu.Item key="0">
                  <Link href={`/contacts/123`}>
                    <a>Details</a>
                  </Link>
                </Menu.Item>
                <Menu.Item key="1">
                  <Popconfirm
                      title="Are you sure to delete this contact?"
                      onConfirm={async () => onDelete(contact)}
                  >
                    <a>Delete</a>
                  </Popconfirm>
                </Menu.Item>
                <Menu.Item key="2">
                  <a href={`/triggers/${trigger && trigger.id}/actions`}>
                    <EditOutlined className="mr-2" />
                    Edit Action
                  </a>
                </Menu.Item>
              </Menu>
          );
          return (
              <span className="operations">
                <Dropdown overlay={menu} trigger={['click']}>
                  <a className="ant-dropdown-link" onClick={e => e.preventDefault()}>
                    Operations <DownOutlined />
                  </a>
                </Dropdown>
            </span>
          );
        },
      },
    ];

    return columns;
  }
};
