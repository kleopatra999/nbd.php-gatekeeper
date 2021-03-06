<?php

namespace Behance\NBD\Gatekeeper\RulesetProviders;

use Behance\NBD\Gatekeeper\RuleFactory;
use Behance\NBD\Gatekeeper\Ruleset;
use Behance\NBD\Gatekeeper\RulesetProviderInterface;

class ConfigProvider implements RulesetProviderInterface {

  private $_config;

  /**
   * @var array
   */
  private $_generated_rulesets = [];

  public function __construct( array $config ) {

    $this->_config = $config;

  }

  /**
   * {@inheritdoc}
   */
  public function getRuleset( $feature ) {

    if ( isset( $this->_generated_rulesets[ $feature ] ) ) {
      return $this->_generated_rulesets[ $feature ];
    }

    $ruleset = new Ruleset();

    if ( !isset( $this->_config[$feature] ) ) {
      return $ruleset;
    }

    $raw_rules = $this->_config[$feature];

    foreach ( $raw_rules as $rule_info ) {

      $rule = RuleFactory::create( $rule_info['type'], $rule_info['params'] );
      $ruleset->addRule( $rule );

    }

    $this->_generated_rulesets[$feature] = $ruleset;

    return $ruleset;

  } // getRuleset

}
