import { camelCase, capitalize } from 'lodash';

// Laura 提供
// https://github.com/OnrampLab/samurai-world-client/pull/662
// 未測試
/**
 * e.g.
 *    twilio -> Twilio
 */
export const titleCase = (string?: string) => {
  if (!string) return string;

  const lowercaseWords = [ 'a', 'after', 'and', 'at', 'before', 'between', 'by', 'for', 'from', 'in', 'near', 'of', 'on', 'since', 'the', 'to', 'under'];
  const uppercaseWords = ['ivr', 'sms', 'id', 'ai', 'fb'];
  const stringArray = string.toLowerCase().split(' ').map(word => {
    return lowercaseWords.includes(word) ? word
     : uppercaseWords.includes(word) ? word.toUpperCase()
     : capitalize(word);
  });
  return stringArray.join(' ');
};
