<?php

namespace App\Traits;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

trait LogsActivity
{
    protected static function bootLogsActivity()
    {
        foreach (static::getRecordableEvents() as $event) {
            static::$event(function ($model) use ($event) {
                $model->logActivity($event);
            });
        }
    }

    protected static function getRecordableEvents()
    {
        if (isset(static::$recordEvents)) {
            return static::$recordEvents;
        }
        return ['created', 'updated', 'deleted'];
    }

    public function logActivity($action)
    {
        // Don't log if we are running in console (like seeding) unless desired
        // Or at least handle null user
        $userId = Auth::id();
        
        $description = $this->getActivityDescription($action);
        $properties = $this->getActivityProperties($action);

        ActivityLog::create([
            'user_id' => $userId,
            'action' => $action,
            'model_type' => get_class($this),
            'model_id' => $this->id,
            'description' => $description,
            'properties' => $properties,
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
        ]);
    }

    protected function getActivityDescription($action)
    {
        $modelName = class_basename($this);
        return "{$modelName} was {$action}";
    }

    protected function getActivityProperties($action)
    {
        if ($action === 'updated') {
            return [
                'old' => array_intersect_key($this->getOriginal(), $this->getDirty()),
                'attributes' => $this->getDirty(),
            ];
        }

        if ($action === 'created') {
            return [
                'attributes' => $this->toArray(),
            ];
        }

        return null;
    }
}
