<?php

/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license.
 */

namespace Ilbox\Doctrine\Traits;

/**
 * Class CreateEntityIfNotFindedRepositoryTrait
 *
 * @author Elias Bulychov
 * @package Ilbox\Doctrine\Traits
 */
class CreateEntityIfNotFindedRepositoryTrait
{
    /**
     * If findOneBy return empty result, create new object, and setting values of properties by $criteria.
     * 
     * @param array $criteria
     * @param array $orderBy
     * @return object
     */
    public function findOneBy(array $criteria, array $orderBy = null)
    {
        $entity = parent::findOneBy($criteria, $orderBy);

        if (!$entity) {
            $entity = new $this->_class->name;
            foreach ($criteria as $fieldName => $value) {
                $setter = 'set' . \Doctrine\Common\Util\Inflector::classify($fieldName);
                $entity->$setter($value);
            }
            $this->_em->persist($entity);
        }

        return $entity;
    }
}
