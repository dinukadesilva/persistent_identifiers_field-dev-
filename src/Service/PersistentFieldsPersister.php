<?php

namespace Drupal\persistent_fields\Service;

class PersistentFieldsPersister {

    /**
     * This function is a customized implementation of persist function of Persistent Identifiers
     * @return boolean  
     */
    public function persist(&$entity, $pid, $target_field, $save = TRUE){
        //dpm($target_field);
        //dpm($entity->hasField($target_field));

        if (method_exists($entity, 'hasField') && $entity->hasField($target_field)) {
            //\Drupal::logger('persistent_fields')->warning("Inside If Loop");
            //$title=$target_field."_".$pid;
            //$entity->setTitle($title);
            //dpm($entity->{$target_field});
            $entity->{$target_field} = $pid;
        }
        else {
            \Drupal::messenger()->addMessage(t('This node does not have the required field (@field)', ['@field' => $target_field]));
        }
        if ($save) {
            $entity->save();
        }
        return TRUE;
    }


}