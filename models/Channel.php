<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "channel".
 *
 * @property int $id
 * @property double $channelNo
 * @property string $channel
 * @property string $channelName
 * @property string $channelShortName
 * @property string $liveUrl
 * @property string $imgpath
 * @property string $intro
 * @property string $province
 * @property string $city
 * @property string $county 县
 * @property int $likeCount
 * @property int $listenCount
 * @property int $mark_delete
 * @property string $createTime
 * @property string $updateTime
 * @property int $sort
 * @property int $is_push
 * @property int $radio_id 频率流ID
 * @property int $is_show 是否显示
 * @property int $is_sign 是否签约
 * @property int $can_pub 0:关闭 1:打开 2:仅管理员
 * @property int $is_default 是否默认频率
 * @property string $QRCode 频率二维码
 */
class Channel extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'channel';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['channelNo'], 'number'],
            [['liveUrl', 'city', 'QRCode'], 'required'],
            [['likeCount', 'listenCount', 'mark_delete', 'sort', 'is_push', 'radio_id', 'is_show', 'is_sign', 'can_pub', 'is_default'], 'integer'],
            [['createTime', 'updateTime'], 'safe'],
            [['channel', 'channelName', 'channelShortName', 'province'], 'string', 'max' => 50],
            [['liveUrl'], 'string', 'max' => 150],
            [['imgpath', 'intro', 'QRCode'], 'string', 'max' => 255],
            [['city', 'county'], 'string', 'max' => 80],
            [['channelName'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'channelNo' => 'Channel No',
            'channel' => 'Channel',
            'channelName' => 'Channel Name',
            'channelShortName' => 'Channel Short Name',
            'liveUrl' => 'Live Url',
            'imgpath' => 'Imgpath',
            'intro' => 'Intro',
            'province' => 'Province',
            'city' => 'City',
            'county' => 'County',
            'likeCount' => 'Like Count',
            'listenCount' => 'Listen Count',
            'mark_delete' => 'Mark Delete',
            'createTime' => 'Create Time',
            'updateTime' => 'Update Time',
            'sort' => 'Sort',
            'is_push' => 'Is Push',
            'radio_id' => 'Radio ID',
            'is_show' => 'Is Show',
            'is_sign' => 'Is Sign',
            'can_pub' => 'Can Pub',
            'is_default' => 'Is Default',
            'QRCode' => 'Qrcode',
        ];
    }

    /**
     * 根据aChannelId查找主的名称与频点
     * @param $aChannelId array
     * @return array
     */
    public static function getMainChannel($aChannelId = [])
    {
        if(empty($aChannelId)){
            return [];
        }

        $aMainChannel = self::find()
            ->where(['id' => $aChannelId])
            ->select(['id as channel_id', 'channelName as channel_name', 'fm', 'am', 'province', 'city', 'radio_id', 'intro as introduction', 'imgpath as logo', 'liveUrl as live_url', 'channelName as call_name'])
            ->asArray()
            ->all();
        if($aMainChannel){
            return $aMainChannel;
        }
        return [];
    }
}
