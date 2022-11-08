<?php

function type_basic(object $resource)
{
  if ($resource instanceof UserList) {
    $service = new ListService();
  }
  elseif ($resource instanceof Blog) {
    $service = new BlogService();
  }
  
  return $service ?? null;
}




function type_1(object $resource)
{
  $map = map();
  $resourceClassName = get_class($resource);
  if (!isset($map[$resourceClassName])) {
      Log::warning('Not support parse the resource: ' . get_class($resource));
      return null;
  }

  $serviceClient = $map[$resourceClassName];
  $result = $serviceClient::parseName($resource->getName());
}

function map(): array
{
    return [
        Resources\UserList::class => Gapic\ListService::class,
        Resources\AdGroup::class  => Gapic\BlogService::class,
    ];
}
