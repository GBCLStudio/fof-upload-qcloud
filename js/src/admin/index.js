import app from 'flarum/app';

app.initializers.add('gbcl-fof-upload-qcloud', function (app) {

    const setting = (s) => app.translator.trans(`gbcl-fof-upload-qcloud.qcloudConfig.${s}`)
    const label = (s) => app.translator.trans(`gbcl-fof-upload-qcloud.admin.labels.qcloudLabel.${s}`)
    const help = (s) => app.translator.trans(`gbcl-fof-upload-qcloud.admin.labels.qcloudHelp.${s}`)

    app.extensionData
        .for('gbcl-fof-upload-qcloud')
        .registerSetting(
            {
                setting: setting('secretId'),
                label: label('secretId'),
                help: help('secretId'),
                type: 'text',
            },
            1010
        )
        .registerSetting(
            {
                setting: setting('secretKey'),
                label: label('secretKey'),
                help: help('secretKey'),
                type: 'text',
            },
            1000
        )

        .registerSetting(
            {
                setting: setting('region'),
                label: label('region'),
                help: help('region'),
                type: 'select',
                options: {
                    'ap-beijing': label('regionOption.ap-beijing'),
                    'ap-chengdu': label('regionOption.ap-chengdu'),
                    'ap-chongqing': label('regionOption.ap-chongqing'),
                    'ap-guangzhou': label('regionOption.ap-guangzhou'),
                    'ap-nanjing': label('regionOption.ap-nanjing'),
                    'ap-shanghai': label('regionOption.ap-shanghai'),
                    'ap-tokyo': label('regionOption.ap-tokyo'),
                    'eu-frankfurt': label('regionOption.eu-frankfurt'),
                    'na-siliconvalley': label('regionOption.na-siliconvalley'),
                },
                default: 'ap-beijing',
            },
            550
        )

        .registerSetting(
            {
                setting: setting('appId'),
                label: label('appId'),
                help: help('appId'),
                type: 'text',
            },
            540
        )
        .registerSetting(
            {
                setting: setting('domain'),
                label: label('domain'),
                help: help('domain'),
                type: 'text',
            },
            530
        )

        .registerSetting(
            {
                setting: setting('bucket'),
                label: label('bucket'),
                help: help('bucket'),
                type: 'text',
            },
            510
        )

        .registerSetting(
            {
                setting: setting('useHttps'),
                label: label('useHttps'),
                type: 'select',
                options: {
                'enableTls': label('schemeOption.enableTls'),
                'disableTls': label('schemeOption.disableTls'),
                },
                default: 'No',
            },
            500
        )

        .registerSetting(
            {
                setting: setting('fileRetrievingSignatureToken'),
                label: label('fileRetrievingSignatureToken'),
                help: help('fileRetrievingSignatureToken'),
                type: 'text',
            },
            400
        )
        .registerSetting(
            {
                setting: setting('fileRetrievingSignatureTokenName'),
                label: label('fileRetrievingSignatureTokenName'),
                help: help('fileRetrievingSignatureTokenName'),
                type: 'text',
        },
        300
      )
        .registerSetting(
            {
                setting: setting('fileRetrievingSignatureTime'),
                label: label('fileRetrievingSignatureTime'),
                help: help('fileRetrievingSignatureTime'),
                type: 'text',
        },
         200
      )
});
