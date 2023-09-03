// --------------------------------------------------------------------------------
// Segment.d.ts
// --------------------------------------------------------------------------------

export enum SegmentTriggerType {
  SCHEDULED = 'scheduled-segment-trigger',
  IMMEDIATE = 'event-segment-trigger',
  DEPENDENCY = 'dependency-segment-trigger',
}

// --------------------------------------------------------------------------------
// main.tax
// --------------------------------------------------------------------------------
import { SegmentTriggerType } from '@onr/segment';

const [isDependencySegmentTrigger, setIsDependencySegmentTrigger] = useState<boolean>(
  currentSegmentTrigger.id ? currentSegmentTrigger.type === SegmentTriggerType.DEPENDENCY : false,
);

const triggerTypeMap = {
  [SegmentTriggerType.SCHEDULED]: 'Scheduled',
  [SegmentTriggerType.IMMEDIATE]: 'Immediate',
  [SegmentTriggerType.DEPENDENCY]: 'Dependency',
};

const displayTriggerTypeName = (type: string): string => {
  return triggerTypeMap[type as SegmentTriggerType] || type;
};

