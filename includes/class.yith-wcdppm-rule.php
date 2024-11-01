<?php

/*
 * This file belongs to the YIT Framework.
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */
if ( !defined( 'YITH_WCDPPM_VERSION' ) ) {
    exit( 'Direct access forbidden.' );
}

if (!class_exists('YITH_WCDPPM_Rule') ){

    /**
     * YITH_WCDPPM_Object
     *
     * @since 1.0.0
     */
    class YITH_WCDPPM_Rule {
        /**
         * id of Dynamic Payment Method object
         *
         * @var int
         * @since 1.0.0
         */
        public $id;

        /**
         * post of Dynamic Payment Method object
         *
         * @var WP_Post|bool
         * @since 1.0.0
         */
        public $post;

        /**
         * Constructor
         *
         * @param int  $rule the Dynamic Payment Method id
         * @param array $args array of meta for creating booking
         *
         * @since  1.0.0
         * @author Carlos Rodriguez <carlos.rodriguez@yourinspiration.it>
         */
        public function __construct( $rule = 0, $args = array() ) {
            //the rule if $rule_id is defined
            if ( $rule ) {
                if ( is_numeric( $rule ) ) {
                    $this->id   = absint( $rule );
                    $this->post = get_post( $this->id );
                } elseif ( $rule instanceof YITH_WCDPPM_Object ) {
                    $this->id   = absint( $rule->id );
                    $this->post = $rule->post;
                } elseif ( isset( $rule->ID ) ) {
                    $this->id   = absint( $rule->ID );
                    $this->post = $rule;
                }
            }
        }

        /**
         * __get function.
         *
         * @param string $key
         *
         * @return mixed
         */
        public function __get( $key ) {

            $value = get_post_meta( $this->id, '_' . $key, true );

            if ( !empty( $value ) ) {
                $this->$key = $value;
            }

            return $value;
        }

        /**
         * __isset function.
         *
         * @param string $key
         *
         * @return mixed
         */
        public function __isset( $key ) {

            return metadata_exists( 'post', $this->id, '_' . $key );
        }

        /**
         * __set function.
         *
         * @param string $property
         * @param mixed  $value
         *
         * @return bool|int
         */
        public function set( $property, $value ) {

            $this->$property = $value;

            return update_post_meta( $this->id, '_' . $property, $value );
        }
    }

}