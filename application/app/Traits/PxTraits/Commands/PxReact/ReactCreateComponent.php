<?php
namespace App\Traits\PxTraits\Commands\PxReact;
use File;
use Str;
trait ReactCreateComponent
{
    public function MakeReactCreateComponent()
    {
        $d = $this->getDefaults();
        $model = $d['model'];
        $name =  ucfirst($d['name']);
        $properNameSpace = $d['properNameSpace'];
        $pageUrl = $d['pageUrl'];
        $d = $this->getDefaults();
        $properNameSpace = $d['properNameSpace'];
        $path = base_path("resources\\js\\app") . "\\" . $properNameSpace."\\";
        if (!is_dir($path)) {
            File::makeDirectory($path, 0755, true);
        }
        $filePath = $path . $name . '.js';
        if (!File::exists($filePath)) {
            $content = $this->ReactCreateString($name);
            File::put($filePath, $content);
            $this->info("Component " . $name . ".js created ");
        }
    }

    public function ReactCreateString($name)
    {
        $codeString = <<<PHP
        import GP from '@app/Components/Common/GlobalProps';
        import React, { Component } from 'react';
        import { createRoot } from 'react-dom/client';

        export default class {$name} extends Component {
            constructor(props) {
                super(props);
                this.state = {
                    loading: true,
                    hasLoaded: false,
                    dbResponse: [],
                    ed: {},
                }
            }
            componentDidMount() {
                this.setState((prevState) => {
                    return {
                        ...prevState,
                        loading: false
                    }
                });
            }
            render() {
                const { loading, dbResponse = [], hasLoaded, ed = {} } = this.state;
                if (loading) {
                    return (<></>)
                }
                return (
                    <div>
                        Data 
                    </div>
                )
            }
        }
        if (document.getElementById('{$name}')) {
            createRoot(document.getElementById('{$name}')).render(<{$name} />)
        }
        PHP;
        return $codeString;
    }
}
