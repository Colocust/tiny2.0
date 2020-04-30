<?php

namespace Tiny\Event;

interface Event {
  public function handleOver();

  public function handleError();

  public function listeners(): array;
}
