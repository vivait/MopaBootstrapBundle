<?php

/*
 * This file is part of the MopaBootstrapBundle.
 *
 * (c) Philipp A. Mohrenweiser <phiamo@googlemail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mopa\Bundle\BootstrapBundle\Form\Extension;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

/**
 * Extension for Date type.
 *
 * @author phiamo <phiamo@googlemail.com>
 */
class DateTypeExtension extends AbstractTypeExtension
{
    /**
    * {@inheritdoc}
    */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['input_wrapper_class'] = isset($options['input_wrapper_class']) ? $options['input_wrapper_class'] : null;
        $view->vars['separator_wrapper_class'] = isset($options['separator_wrapper_class']) ? $options['separator_wrapper_class'] : null;
    }

    /**
     * {@inheritdoc}
     */
    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        if ('single_text' === $options['widget']) {
            if (isset($options['datepicker'])) {
                $view->vars['datepicker'] = $options['datepicker'];
            }
            else {
                $view->vars['date_placeholder_pattern'] = $options['format'];
            }
        }

        if (!empty($view->vars['date_pattern'])) {
            $pattern = $view->vars['date_pattern'];

            $view->vars['html_date_pattern'] = preg_replace('#(?<=^|\})([^\{\}]+?)(?=\{|$)#', '<span class="{{ date_separator_wrapper_class }}">$1</span>', $pattern);
        }

        $date_format = '%04d-%02d-%02d';
        $view->vars['date_max'] = sprintf($date_format, max($options['years']), max($options['months']), max($options['days']));
        $view->vars['date_min'] = sprintf($date_format, min($options['years']), min($options['months']), min($options['days']));
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setOptional(array(
            'datepicker',
            'input_wrapper_class',
            'separator_wrapper_class'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getExtendedType()
    {
        return 'date';
    }
}
